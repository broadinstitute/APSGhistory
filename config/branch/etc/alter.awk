#!/bin/sh
# Awk version of [dk_]alter, for [t]csh.
# Usage: alter OPERATION [ -a ] VARIABLE COMPONENT [SEP]
# Or: dk_alter OPERATION        VARIABLE COMPONENT [SEP]
# _dk_opt_a may be set in the environment.

swhere() {
  test -x     /bin/$1 && { echo     /bin/$1; return 0; }
  test -x /usr/bin/$1 && { echo /usr/bin/$1; return 0; }
  return 1
}
test=`swhere test`
AWK=`swhere nawk` || AWK=`swhere gawk` || AWK=`swhere awk`

# Awk args are $1=VAR, $2=COMP, $3=IFS, $4=opt_a, $5=oldval_of_VAR
f_use()
{
  eval oldval=\"\${$1}\"
  $AWK 'BEGIN {
    printf("setenv %s \"", ARGV[1])
    #printf("setenv %s %s", ARGV[1], "\047")
    if (ARGV[5] != "") {
      if (ARGV[4] == 0) { # prepend
        if (ARGV[5] ~ /^[.]/) {
          printf(".%s%s", ARGV[3], ARGV[2]); 
          printf("%s", substr(ARGV[5], 2))
        } else {
          printf("%s%s%s", ARGV[2], ARGV[3], ARGV[5]);
        }
      } else { # append
        if (ARGV[5] ~ /[.]$/) {
          printf("%s", substr(ARGV[5], 1, length(ARGV[5]) - 1))
          printf("%s%s.", ARGV[2], ARGV[3]); 
        } else {
          printf("%s%s%s", ARGV[5], ARGV[3], ARGV[2]);
        }
      }
    } else { # No prior value for variable.
      printf("%s", ARGV[2]);
    }
    printf("\"\n")
    #printf("%s\n", "\047")
  }' "$@" "$oldval"
}

# Awk args are $1=VAR, $2=COMP, $3=IFS, $4=opt_a, $5=oldval_of_VAR
f_unuse()
{
  eval oldval=\"\${$1}\"
  $AWK 'BEGIN {
    m = split(ARGV[2], pattern, ARGV[3])
    n = split(ARGV[5], string, ARGV[3])
    if (m==0) { pattern[1] = ""; m=1; }
    if (n==0) { string[1] = ""; n=1; }
    printf("setenv %s \"", ARGV[1])
    p = findpat(pattern, m, string, n, (ARGV[4] == 0))
    if (p) { # Match at index p.
      i = 1
      if (p>1) {
        printf("%s", string[1])
        for(i=2;i<p;i++) printf("%s%s", ARGV[3], string[i])
      }
      if (p+m <= n) {
        if (i >= 2) printf("%s", ARGV[3])
        printf("%s", string[p+m])
        for(i=p+m+1;i<=n;i++) printf("%s%s", ARGV[3], string[i])
      }
    } else # No match.
      printf("%s", ARGV[5]);
    printf("\"\n")
  }
  function findpat(x, m, y, n, findfirst,    st, j,retval){
    retval = 0
    st = 1
    for (j=1; j<=n; j++)
      if (x[st] == y[j]) {
        if (++st > m) {
          if(findfirst)
            return j-m+1
          else
            retval = j-m+1
        }
      } else
        st = 1
    return retval
  }' "$@" "$oldval"
}

# Main
test -n "$_dk_err" && exit 0
op=$1 # use or unuse
shift
opt_a=${_dk_opt_a:-0}
test "$1" = "-a" && { opt_a=1; shift; }
ifs="${3:-${DK_IFS:-:}}"
f_$op $1 "$2" "$ifs" $opt_a
