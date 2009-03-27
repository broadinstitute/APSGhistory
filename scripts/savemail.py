#!/usr/bin/env python

import re
import sys
import email
import os
import stat

# Create message from stdin
message = email.message_from_file(sys.stdin)

# Get a filename to write to using message ID
mname = "/local/rt144332/msg-" + re.match(r"<(.*)@.*", message.get("Message-Id")).group(1)

# Open file, write message, close file
mfile = open(mname, "a")
mfile.writelines(message.as_string())
mfile.close

# Chmod so file is readable by someone other than mail.
os.chmod(mname, stat.S_IRUSR|stat.S_IWUSR|stat.S_IRGRP|stat.S_IWGRP|stat.S_IROTH|stat.S_IWOTH)

