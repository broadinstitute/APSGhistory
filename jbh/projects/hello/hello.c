#include <mpi.h>
#include <stdio.h>
#include <unistd.h>

int
main(int argc, char *argv[])
{
    int rank, size;
    char hostname[64];

    MPI_Init(&argc, &argv);

    MPI_Comm_rank(MPI_COMM_WORLD, &rank);
    MPI_Comm_size(MPI_COMM_WORLD, &size);

    gethostname(hostname, sizeof(hostname));
    
    printf("Hello, World.  I am %d of %d on %s\n", rank, size, hostname);

    MPI_Finalize();
    return 0;
}
