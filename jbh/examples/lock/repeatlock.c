#include <unistd.h>
#include <fcntl.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <stdio.h>
#include <errno.h>
#include <signal.h>

void sighand (int sig) {
	}
	

int main() {
	struct flock dolock, checklock, dounlock;
	struct sigaction alarmhand;
	int fd,ret,i;

	dolock.l_type=F_WRLCK;
	dolock.l_whence=SEEK_SET;
	dolock.l_start=0;
	dolock.l_len=0;
	dolock.l_pid=0;

	dounlock.l_type=F_UNLCK;
	dounlock.l_whence=SEEK_SET;
	dounlock.l_start=0;
	dounlock.l_len=0;
	dounlock.l_pid=0;


	fd=open("lockfile", O_RDWR|O_CREAT, S_IRWXU);

	alarmhand.sa_handler=&sighand;

	ret=-1;
	sigaction(SIGALRM, &alarmhand, NULL);
	for (i=0; i<10 && ret==-1; i++) {
		printf("i=%d\n",i);
		alarm(5);
		ret=fcntl(fd, F_SETLKW, &dolock);
		if ( ret==-1 ) {
			perror("fcntl");
			}
		else {
			alarm(0);
			printf ("locked\n");
			}
		}

	sleep(30);
	ret=fcntl(fd, F_SETLK, &dounlock);
	if ( ret==-1 ) {
		perror("fcntl");
		}
	else {
		printf ("unlocked\n");
		}

	close(fd);
}
