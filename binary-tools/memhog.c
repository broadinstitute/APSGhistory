#include <assert.h>
#include <stdlib.h>
#include <stdio.h>

int main (int argc, char **argv) {
  assert(argc == 1);

  // Just hog a GB; run a bunch in parallel if you want more hogged.
  size_t gb = 1; //atoll(argv[1]);

  int *a;

  if (a = calloc(1, gb<<30)) { ; }
  else                       { perror("couldn't allocate memory"); exit(-1); }

  unsigned long i;

  for (i = 0; i < gb<<30 /4; i++) { a[i] = 0xDEADBEEF; };

  return(0);
}
