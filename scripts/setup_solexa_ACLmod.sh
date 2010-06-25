#!/bin/sh
chmod +a group "sequence" allow object_inherit,generic_all $1
chmod +a group "sequence" allow container_inherit,generic_all $1
chmod +a everyone allow object_inherit,generic_read,generic_exec $1
chmod +a everyone allow container_inherit,generic_read,generic_exec $1
