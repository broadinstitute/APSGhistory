import java.io.*;

class NfsMountTester {
  
  static boolean checkNfsMount(String path) throws IOException {
    
    String command = "/broad/tools/NoArch/pkgs/local/checkNFS.sh -q " + path;
    
    Process proc = Runtime.getRuntime().exec(command);

    BufferedReader result = new BufferedReader(new InputStreamReader(proc.getInputStream()));
  
    String line = null;
    while ((line = result.readLine()) != null) {
      System.out.println(line);
    }
  
    try {
      if (proc.waitFor() != 0) { 
         System.err.println("exit value = " + proc.exitValue());
      }
    }
    catch (InterruptedException e) {
      System.err.println(e);
    }
  }



  public static void main (String[] args) {
      
    for (int i = 0; i < args.length; i++){
      System.out.println(args[i]);
      try {
        checkNfsMount(args[i]);
      } 
      catch (IOException e) {
                e.printStackTrace();  
      }

    }
  }
}
  


