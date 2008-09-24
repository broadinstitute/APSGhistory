#!/util/bin/python

#####
#
# This script syncronizes the nt and htg databases of /ibm_local/blastdb
# on specified farm nodes. It is run on the APSG blade (node ) during
# <source node info here>
#
# Nodes are identified and organized by set (chassis number, oneoff or
# four54). Eight random sets are chosen and one node is identified from
# each for NSF parallel sync. Henceforth, each available source eligible
# node scans for an unprocessed node, with the following preference
# scheme:
#
# a. sets with no source eligible nodes
# b. nodes within the same set as the source node
# c. any unprocessed node
# 
#
# After selection, destination node status is set to "running" and rsync
# is initiated. Upon sucessful rsync, node status "complete".  If rsync
# fails, destination node returns to "unprocessed" status and the retry
# count is incremented. After 5 retries, sync status is set to "failed".
#
# When all rsyncs are complete and there are no more unprocessed
# nodes, a status summary is created and blast@broad is notified.
#
#####

import os, signal

nfs_parallel = 8
node_parallel = 2
max_retries = 5

statuses = ['unprocessed', 'running', 'complete', 'failed']

rsync = '/usr/bin/rsync'
rsync_args = '-rlptDL --delete --exclude="queries/" --exclude="ftpdownload/"'
rsync_ssh_args = '-e ssh'
nfs_source = '/broad/data/blastdb/'
local_dir = '/ibm_local/blastdb/'
hostlists_dir = '/broad/tools/hostlists/'
ssh = '/usr/bin/ssh'

rsync = '/bin/echo'
rsync_args = ''
rsync_ssh_args = ''

pids = {}
nodes = {}
nodes.update(dict.fromkeys(['node243', 'node244', 'node245', 'node246',
                            'node247', 'node248', 'node249'],
                           {'set': 'oneoffs', 'retries': 0,
                            'status': 'unprocessed', 'pids':[] }))
nodes.update(dict.fromkeys(['node126', 'node219', 'node220', 'node224'],
                           {'set': 'four54', 'retries':0,
                            'status': 'unprocessed', 'pids':[] }))

for chassis in ['01', '02', '03', '04','05', '06', '07',
                '10', '13', '14', '15', '17']:
    setname = 'blades'+chassis
    for node in open(hostlists_dir + setname):
        node = node.strip()
        nodes[node]={'set': setname, 'retries':0,
                     'status':'unprocessed', 'pids':[] }

###
# process handling (start/stop)
### 

def rsync_nfs(node):
    pid = os.spawnv(os.P_NOWAIT, ssh,
                    (ssh, node, rsync, rsync_args, nfs_source, local_dir))
    pids[pid] = { 'dstnode' : node }
    nodes[node]['status'] = 'running'

def rsync_ssh(srcnode,dstnode):
    pid = os.spawnv(os.P_NOWAIT, ssh,
                    (ssh, srcnode, rsync, rsync_args, rsync_ssh_args,
                     local_dir, dstnode + ':' + local_dir ))
    pids[pid] = { 'srcnode' : srcnode, 'dstnode' : dstnode }
    nodes[dstnode]['status'] = 'running'
    nodes[srcnode]['pids'].append(pid)

def sigchld_handler(signum, stackframe):
    while pids:
        pid, exitcode = os.waitpid(0,os.WNOHANG)
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
signal.signal(signal.SIGALRM,signal.SIG_IGN)

for node in candidates.values():
    rsync_nfs(node)

while True:
    can_update = []
    need_update = []
    for node in nodes:
        if (nodes[node]['status'] == 'complete' and
            len(nodes[node]['pids']) <= node_parallel):
            can_update.append(node)
        elif nodes[node]['status'] == 'unprocessed':
            need_update.append(node)
    print 'need',need_update
    print 'can',can_update
    if not need_update:
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

for node in nodes:
    print node,nodes[node]['status']

print 'done'
