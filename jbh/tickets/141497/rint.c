#include <stdio.h>
#include <math.h>

int main(int argc, char **argv)
{
  double a, b;
  double rint(double x);

  a = 0.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 0.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 1.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 1.74999999; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);

  a = 1.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);

  a = 2.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 2.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);

  a = 289440.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 289440.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 289441.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 289441.74999999; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);

  a = 289441.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);

  a = 289442.59; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  
  a = 289442.75; 
  b = rint(a); 
  printf("%15.12f %15.12f\n", a, b);
  

  
}
