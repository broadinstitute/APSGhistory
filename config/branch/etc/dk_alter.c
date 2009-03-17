/*
 * This is a C implementation of the dk_alter machinery.  It is research,
 * or work-in-progress.  I haven't figured out how to resolve some difficult
 * issues with passing white-space or empty arguments between the C-shell
 * and this process.
 * 
 * The current C-shell implementation of dk_alter (see ../csh/.dk_alter)
 * is rather long, slow, and complicated.  For Dotkit code that includes a
 * lot of alter or dk_alter calls, the C-shell version can be 20x slower,
 * or worse, than the ksh and bash versions.
 * 
 * The idea is to put a fast dk_alter executable at
 * $DK_ROOT/etc/$SYS_TYPE/dk_alter.  (Or a SYS_TYPE independent awk version
 * at $DK_ROOT/etc/alter.awk.)  Then the *alter aliases for csh would be
 * defined as
 * 
 *   alias dk_alter 'eval "`$DK_ROOT/etc/$SYS_TYPE/dk_alter $_dk_op \!*`"'
 *   alias alter 'eval "`$DK_ROOT/etc/$SYS_TYPE/dk_alter use \!*`"'
 *   alias unalter 'eval "`$DK_ROOT/etc/$SYS_TYPE/dk_alter unuse \!*`"'
 * 
 * The result (printed to stdout) of calling this C executable is just an
 * appropriate "setenv FOO BAR" statement, eval'ed by the parent shell.
 * The basic idea is workable, and appears to be roughly 2x faster than
 * the native C-shell code currently in place.  (The awk version is perhaps
 * 1.5x faster.)
 * 
 * It falls apart when one of the arguments to the dk_alter alias contains
 * space or tab characters, or when the new result (BAR) contains white
 * space.  I haven't been able to come up with any quoting scheme that
 * preserves white space in both directions, while also allowing variable
 * interpolation.
 * 
 * So for now this approach waits for a smarter implementation.
 *
 * Lee Busby
*/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>

/* Quick Search, variant of Boyer-Moore. */
/* See http://www-igm.univ-mlv.fr/~lecroq/string/ */
/* Alphabet size: ASCII character set */
#define ASIZE 256
void preQsBc(char *x, int m, int qsBc[]) {
  int i;
  for (i=0; i < ASIZE; ++i)
    qsBc[i] = m+1;
  for (i=0; i < m; ++i)
    qsBc[x[i]] = m-i;
}

/* Find pattern x, length m, in string y, length n, separator ifs. */
/* Return the first instance if findfirst is true, otherwise last. */
int QS(char *x, int m, char *y, int n, char ifs, int findfirst) {
  int retval = -1, j, qsBc[ASIZE];
  preQsBc(x, m, qsBc); /* Preprocess */
  j = 0; /* Search */
  while (j <= n-m) {
    if (memcmp(x, y+j, m) == 0)
      if ( (j==0 || y[j-1]==ifs) && ( (j+m)==n || y[j+m]==ifs ) )
        if (findfirst) return j; else retval = j;
    j += qsBc[y[j+m]]; /* shift */
  }
  return retval; /* -1 if pattern was not found in string. */
}

void alter(int prepend, char *var, char *oldval, char *newword, char ifs) {
  int n=strlen(oldval);
  printf("setenv %s \"", var);
  if (n > 0) {
    if (prepend) {
      if (oldval[0] == '.') {
        printf(".%c%s", ifs, newword); 
        if (n > 1) fwrite(oldval + 1, 1, n-1, stdout);
      } else
        printf("%s%c%s", newword, ifs, oldval);
    } else { /* Append */
      if (oldval[n-1] == '.') {
        if (n > 1) fwrite(oldval + 0, 1, n-1, stdout);
        printf("%s%c.", newword, ifs); 
      } else
        printf("%s%c%s", oldval, ifs, newword);
    }
  } else { /* strlen(oldval) == 0 */
    printf("%s", newword);
  }
  printf("\"\n");
}

void unalter(int prepend, char *var, char *oldval, char *newword, char ifs) {
  int j, k, m=strlen(newword), n=strlen(oldval);
  printf("setenv %s \"", var);
  if ((j = QS(newword, m, oldval, n, ifs, prepend)) != -1) { /* Match */
    k = m + ( (j > 1) ? j : 1);
    if (j > 1) fwrite(oldval    , 1, j-1, stdout);
    if (k < n) fwrite(oldval + k, 1, n-k, stdout);
  } else /* No match */
    printf("%s", oldval);
  printf("\"\n");
}

/* Usage: dk_alter use|unuse [ -a ] VARNAME NEWVALUE [ IFS ] */
int main(int argc, char *argv[]) {
  char ifs = ':', opt_a = '0', *cp;
  int v = 2, nv = 3;
  void (*fp)(int, char *, char *, char *, char) = alter;

  if ( (cp = getenv("_dk_opt_a")) != NULL) opt_a = *cp;
  if (argc == 6) {
    opt_a = '1'; /* -a option was argv[2] */
    ifs = argv[5][0];
    v = 3; /* index of VARNAME */
    nv = 4; /* index of NEWVALUE */
  } else if (argc == 5) {
    if (strcmp(argv[2], "-a") == 0) {
      opt_a = '1';
      v = 3; /* index of VARNAME */
      nv = 4; /* index of NEWVALUE */
      if ((cp = getenv("DK_IFS")) != NULL) ifs = *cp;
    } else {
      ifs = argv[4][0];
    }
  } else if (argc == 4) {
    if ((cp = getenv("DK_IFS")) != NULL) ifs = *cp;
  } else { /* Unexpected arguments: Quietly do nothing. */
    return 0;
  }
  if (argv[1][1] == 'n') fp = unalter;
  if ((cp = getenv(argv[v])) == NULL && (fp == alter)) {
    printf("setenv %s \"%s\"\n", argv[v], argv[nv]);
    return 0; /* VARNAME was previously unset in the environment. */
  }
  (*fp)( (opt_a=='0'), argv[v], cp, argv[nv], ifs);
  return 0;
}
