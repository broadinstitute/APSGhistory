class Chassis:
    def __init__(self, vendor, model, vendor_uuid ):
        self.vendorid = vendorid
        self.model = model
        self.vendor_uuid = vendor.uuid


def ibm_slotinfo (host, username, password):
    prompt = 'system> '
    macre = re.compile('([0-9a-fA-F]{2}[:|\-]?){6}')
    slots = []

    try:
        brsa = telnetlib.Telnet(host)
    except socket.error:
        print "%s refused connection." % host
        return None

    brsa.read_until('username: ')
    brsa.write(username + '\r\n')
    brsa.read_until('password: ')
    brsa.write(password + '\r\n')
    brsa.read_until(prompt)
    for plug in range(1, 15):
        command = 'info -T blade[' + str(plug) + ']\r\n'
        brsa.write(command)
        output = brsa.read_until(prompt)
        macs = []
        for line in output.splitlines():
            mac = macre.search(line)
            if mac:
                macs.append(mac.group().rstrip().lower())
        slot = [ host, plug, macs ]
        if slot:
            slots.append(slot)
    brsa.write('exit\r\n')
    return slots


        
    
