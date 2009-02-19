#!/bin/bash

echo "0" > locktest.txt

for n in {0..128}
  do
    ./lock > lock.out.$n &
  done

