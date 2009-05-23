import java.io.*;

class NfsMountTester {
  
  static boolean checkNfsMount(String path) throws IOException {
    
    String command = "/broad/tools/NoArch/pkgs/local/checkNFS.sh " + path;
    
    Process proc = Runtime.getRuntime().exec(command);

    BufferedReader result = new BufferedReader(new InputStreamReader(proc.getInputStream()));
  
    String line = null;
    while ((line = result.readLine()) != null) {
      System.out.println(line);
    }
  
    try {
      if (proc.waitFor() != 0) { 
         return false;
      }
    }
    catch (InterruptedException e) {
      System.err.println(e);
    }
    return true;
  }

  public static void main (String[] args) {
      
    for (int i = 0; i < args.length; i++){
      try {
        if (checkNfsMount(args[i])) {
          System.out.println( args[i] + " is a valid, accessible path.");
        } else {
          System.out.println( args[i] + " is not a valid, accessible path.");
        }
      } 
      catch (IOException e) {
                e.printStackTrace();  
      }
    }
  }
}
  


