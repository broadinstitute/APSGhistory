#include <stdio.h>

#include <math.h>

int main(int argc, char **argv)
{
  double a, b ;
  double rint(double x) ;

  a = 289440.59 ; b = rint(a) ; printf("%15.12f %15.12f\n", a, b) ;
  a = 289440.75 ; b = rint(a) ; printf("%15.12f %15.12f\n", a, b) ;
}
