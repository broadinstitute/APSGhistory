#!/util/bin/python

#####
#
# Nodes are identified and organized by set (chassis number, oneoff or
# four54). Eight nodes are chosen, each from a different set, for NFS
# parallel sync. Henceforth, each available source eligible node scans
# for an unprocessed node, with the following preference scheme:
#
# a. sets with no source eligible nodes (XXX: not yet implemented)
# b. nodes within the same set as the source node
# c. any unprocessed node
#
# After selection, destination node status is set to "running" and rsync
# is initiated. Upon sucessful rsync, node status "complete".  If rsync
# fails, destination node returns to "unprocessed" status and the retry
# count is incremented. After 5 retries, sync status is set to "failed".
#
# When all rsyncs are complete and there are no more unprocessed
# nodes, a status summary is created.
#
#####

import os, signal, sys

nfs_parallel = 8
node_parallel = 2
max_retries = 5

statuses = ['unprocessed', 'running', 'complete', 'failed']

rsync = '/usr/bin/rsync'
rsync_args = '-W -rlptDL --delete --timeout=600'
rsync_ssh_args = '-e ssh'
nfs_source = '/sysman/scratch/wgastage/'
local_dir = '/local/wga/'
hostlists_dir = '/broad/tools/hostlists/'
ssh = '/usr/bin/ssh'

nfs_sources = [ nfs_source ]
local_sources = [ local_dir ]

pids = {}
nodes = {}

for node in ['node243', 'node244', 'node245', 'node246',
             'node247', 'node248', 'node249']:
    nodes[node] = {'set': 'oneoffs', 'retries': 0,
                   'status': 'unprocessed', 'pids':[]}

for chassis in ['01', '02', '03', '04','05', '06', '07',
                '10', '13', '14', '15', '17']:
    setname = 'blades'+chassis
    for node in open(hostlists_dir + setname):
        node = node.strip()
        nodes[node]={'set': setname, 'retries':0,
                     'status':'unprocessed', 'pids':[]}

###
# process handling (start/stop)
### 

def rsync_nfs(node):
    pid = os.spawnv(os.P_NOWAIT, ssh,
                    [ssh, node, rsync, rsync_args] + nfs_sources + [local_dir] )
    print [ssh, node, rsync, rsync_args] + nfs_sources + [local_dir]
    pids[pid] = { 'dstnode' : node }
    nodes[node]['status'] = 'running'

def rsync_ssh(srcnode,dstnode):
    pid = os.spawnv(os.P_NOWAIT, ssh,
                    [ssh, srcnode, rsync, rsync_args, rsync_ssh_args] +
                     local_sources + [ dstnode + ':' + local_dir])
    print [ssh, srcnode, rsync, rsync_args, rsync_ssh_args] + \
                     local_sources + [ dstnode + ':' + local_dir]
    pids[pid] = { 'srcnode' : srcnode, 'dstnode' : dstnode }
    nodes[dstnode]['status'] = 'running'
    nodes[srcnode]['pids'].append(pid)

def sigchld_handler(signum, stackframe):
    while pids:
        try:
            pid, exitcode = os.waitpid(0,os.WNOHANG)
        except OSError:
            pid = 0
        if pid != 0:
            node = pids[pid]['dstnode']
            src = pids[pid].get('srcnode')
            if exitcode:
                nodes[node]['retries'] = nodes[node]['retries'] + 1
                if nodes[node]['retries'] >= max_retries:
                    nodes[node]['status'] = 'failed'
                else:
                    nodes[node]['status'] = 'unprocessed'
            else:
                nodes[node]['status']='complete'
            if src:
                nodes[src]['pids'].remove(pid)
            pids.pop(pid)
        else:
            break

###
# first pass NFS copies
###

# make candidate list
candidates = {}
for node in nodes:
    if nodes[node]['status'] == 'unprocessed':
        candidates[nodes[node]['set']] = node
    if len(candidates) >= nfs_parallel:
        break

###
# node copies in parallel
###

# signal handling
signal.signal(signal.SIGCHLD,sigchld_handler)
signal.signal(signal.SIGALRM,sigchld_handler)

for node in candidates.values():
    rsync_nfs(node)

while True:
    # important! foo = bar = baz = [] makes them all references to the
    # SAME empty list...  meaning that foo.append(item) adds it to all
    # of them because it's in-place. tricky!
    can_update, need_update, running_update = [],[],[]
    for node in nodes:
        if (nodes[node]['status'] == 'complete' and
            len(nodes[node]['pids']) <= node_parallel):
            can_update.append(node)
        elif nodes[node]['status'] == 'unprocessed':
            need_update.append(node)
        elif nodes[node]['status'] == 'running':
            running_update.append(node)
    if not need_update and not running_update:
        break
    for can in can_update:
        neighbors = [node for node in need_update
                     if nodes[node]['set'] == nodes[can]['set']]
        if neighbors:
            # please won't you be my neighbor?
            mr_rogers = neighbors.pop()
            rsync_ssh(can, mr_rogers)
            need_update.remove(mr_rogers)
        else:
            # go find someone else
            if need_update:
                rsync_ssh(can,need_update.pop())
    signal.alarm(60)
    signal.pause()

for node in sorted(nodes.keys()):
    if nodes[node]['status'] != 'complete':
        print node,nodes[node]['status']
