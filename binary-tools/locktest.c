#include <stdio.h>
#include <unistd.h>
#include <fcntl.h>
#include <errno.h>

/*
 * Codes from firefox-3.0.10 (nsProfileLock.cpp)
 */
int mLockFileDesc;
int mHaveLock;

int
locktest(const char *filename)
{
  int rv = 0;
  mLockFileDesc = open(filename,
                       O_RDWR, 0666);
  if (mLockFileDesc != -1)
    {
      struct flock lock;

      lock.l_start = 0;
      lock.l_len = 0; 
      lock.l_type = F_WRLCK;
      lock.l_whence = SEEK_SET;

      struct flock testlock = lock;
      if (fcntl(mLockFileDesc, F_GETLK, &testlock) == -1)
        {
          close(mLockFileDesc);
          mLockFileDesc = -1;
          rv = -1;
        }
      else if (fcntl(mLockFileDesc, F_SETLK, &lock) == -1)
        {
          close(mLockFileDesc);
          mLockFileDesc = -1;
          if (errno == EAGAIN || errno == EACCES)
            rv = -2;
          else
            rv = -1;
        }
      else
        mHaveLock = 1;
    }
  else
    {
      rv = -1;
    }
  return rv;
}

int
main(int argc, char **argv)
{
  return (locktest(argv[1]) * -1);
}
