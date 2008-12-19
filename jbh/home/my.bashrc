############
#
# User customization file for bash
#
############

umask 002

# Prepend user's bin directory to path
PATH=$HOME/bin:$PATH

# Example of path appending
#PATH=$PATH:/my/additional/directory:/another/directory

# Only set these up for interactive shells
# For example, any 'stty' calls should be inside the if/fi
if [ "${PS1:+set}" = set ]; then
	export EDITOR=emacs
	export VISUAL=$EDITOR
	export EXINIT="set ai aw sm"
	export FCINIT emacs
	export PAGER=less
	export LESS=-ce
	export MAIL=/usr/spool/mail/$USER
	export MAILCHECK=30
	export MAILFILE=$MAIL
	export PRINTER=lw

	alias	ls='ls -CF'
	alias	ll='ls -lg'
	alias	la='ls -A'
	alias	lla='ls -Alg'
	alias	passwd=yppasswd
	alias	sun='stty dec; stty erase \^H'
	alias	dec='stty dec'
	alias	xtitle='echo -n "]0;\!*"'

	PS1='\s:\h:\w \! \$ '
fi

alias mhledit='sudo /usr/local/bin/rc /sysman/install/broad/master.host.listing'
alias mhlbuild='sudo /sysman/install/broad/update'

