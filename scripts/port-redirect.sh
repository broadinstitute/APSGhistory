#!/bin/bash

iptables --table nat --flush
# Forward port 80 to 8080
iptables --table nat -A PREROUTING -p tcp --dport 80 -j REDIRECT --to-port 8080
