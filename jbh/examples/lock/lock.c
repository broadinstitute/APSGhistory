#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <fcntl.h>
#include <unistd.h>
#include <string.h>

int main(int argc, char *argv[])
{
                         /* l_type   l_whence  l_start  l_len  l_pid   */
        struct flock fl = { F_WRLCK, SEEK_SET, 0,       0,     0 };
        char strcounter[32];
        int fd;
        int naptime;
        int counter;
        int mycounter;
        int b;
        int i;

        fl.l_pid = getpid();

        memset(strcounter, '\0', 32);

        if ((fd = open("locktest.txt", O_RDWR, 0664)) == -1) {
                perror("open");
                exit(1);
        }

        while (counter < 1048576){
          if (fcntl(fd, F_SETLKW, &fl) == -1) {
            perror("fcntl");
            exit(1);
          }
          else { 
            lseek(fd, 0, SEEK_SET);
            if ((b = read(fd, strcounter, 31)) == -1) {
              perror("read");
              exit(1);
            }
            else {
              sscanf(strcounter,"%d", &counter);
              counter++;
              sprintf(strcounter, "%d", counter);
              lseek(fd, 0, SEEK_SET);
              write(fd, strcounter, strlen(strcounter));
              printf("PID: %d wrote %d to file.\n", fl.l_pid, counter);
            }
          } 

          naptime = rand() % 4;    
          sleep(1);

          /* Unlock the file */
          fl.l_type = F_UNLCK; 

          if (fcntl(fd, F_SETLKW, &fl) == -1) {
            perror("fcntl");
            exit(1);
          }

        } 
 
        close(fd);
} 

