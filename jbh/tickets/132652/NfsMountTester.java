import java.io.*;

class NfsMountTester {
  
  static int checkNfsMount(String path) throws IOException {

    // This really should do a more intelligent job of finding the checkmount script.    
    String command = "/broad/tools/NoArch/pkgs/local/checkmount " + path;
    
    // Execute the checkmount command.
    Process proc = Runtime.getRuntime().exec(command);

    // We handle the i/o from the process to prevent a deadlock or race condition.
    BufferedReader result = new BufferedReader(new InputStreamReader(proc.getInputStream()));
    String line = null;
    while ((line = result.readLine()) != null) {
      System.out.println(line);
    }
    
    int myErr = 0;
    // Collect the exit value and return it.
    try {
      myErr = proc.waitFor();
    } catch (InterruptedException e) {
      System.err.println(e);
    }
    return myErr;
  }

  public static void main (String[] args) {
      
    for (int i = 0; i < args.length; i++){
      try {
        int errvalue = checkNfsMount(args[i]);
        if ( errvalue == 0 ) {
          // There is no NFS or other error preventing access to the path
          System.out.println( args[i] + " is a valid, accessible path.");
        } else {
          // The attempt to access the path failed or timed out.
          switch (errvalue) {
            case 1:
              // An error code of one means access failed or timed out but the path 
              // is not located on a mounted NFS share or in the autofs map. 
              // Potentially a disk error. Seek help@broad.mit.edu.
              System.out.println("Access failed, path is not in autofs or mounted on NFS.");
              break;
            case 3:
              // An error code of three means access failed or timed out and the path
              // was found in the autofs map but is not currently mounted via NFS.
              // Potentially a hung or dead autofs process, seek help@broad.mit.edu 
              System.out.println("Access failed, path is in autofs map but not currently mounted.");
              break;
            case 5:
              // An error code of five means access failed or timed out and the path
              // is currently mounted via NFS but not found in autofs. This probably
              // means the path is on a manually mounted NFS server which probably means
              // this is a non-standard volume which probably means all bets are off with 
              // some custom NFS server thingy. Failed access immplies that the NFS server
              // is either down or very busy, wait and try again later or seek 
              // help@broad.mit.edu.
              System.out.println("Access failed, path is mounted via nfs but not in autofs map.");
              break;
            case 7:
              // An error code of seven means access failed or timed out and the path
              // is currently mounted via NFS and found in autofs. This probably means 
              // that autofs is working but the NFS server is either down or too busy
              // to respond within the timeout. Wait and try again later or seek 
              // help@broad.mit.edu
              System.out.println("Access failed, path is mounted via nfs and is in autofs map.");
              break;
            case 8: 
              // An error code of eight means that the checkmount script somehow got bad arguments.
              System.out.println("Incorrect checkmount script arguments.");
              break;
            default: 
              // Was checkmount modified without updating sample code?
              System.out.println("Unknown error value, contact help@broad.mit.edu.");
              break;
          }
        }
      } 
      catch (IOException e) {
                e.printStackTrace();  
      }
    }
  }
}
  


