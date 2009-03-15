# A basic .profile for use with Dotkit for ksh.

# We reuse the same file for .profile and $ENV.
if [ -z "$PROFILE_READ" ]; then # Only a login shell takes this branch.
  PROFILE_READ=1 ENV_FILE=$HOME/.profile
  export PROFILE_READ ENV_FILE
  # ENV defined as below expands to null for non-interactive shells.
  # KSH88 otherwise reads $ENV even for non-interactive shells.
  ENV='${ENV_FILE[(_=1)+(_$-=0)-_${-%%*i*}]}'
  export ENV

  # Optional: Before you initialize Dotkit, set DK_NODE to reference any
  # project or group specific dotkits that you want to catalog.
  #export DK_NODE=/my/special/dotkits

  # Look for Dotkit first in $DK_ROOT, then $HOME, then LLNL default.
  if [[ -d "$DK_ROOT" ]]; then
    eval `$DK_ROOT/init -b`
  elif [[ -d "$HOME/dotkit" ]]; then
    eval `$HOME/dotkit/init -b`
  elif [[ -d "/usr/gapps/dotkit" ]]; then
    eval `/usr/gapps/dotkit/init -b`
  fi

  # Basic environment:
  use -q Sys Dev Prefs
fi

#####################################################################
# Remainder of file is read by both login and (interactive) subshells
use -q alia1++ myalia++

# Set won't work from inside a function, so set options outside Dotkit:
set -o ignoreeof -o trackall -o nolog -o vi
