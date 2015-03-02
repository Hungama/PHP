import java.sql.*;
import java.net.*;
import java.io.*;
import java.lang.*;
import java.util.Date;
import java.util.ResourceBundle;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.*;

public class bulkupload extends Thread {

	/**
	 * @param args
	 */
	public static Connection con=null;
	public	String DSN="";
	public	String USR="";
	public	String PWD="";
	public	String IP="";
	public static Statement stmt;
	public String[] arr;
	private Connection dbConn()
	{
		while(true)
		{
			try
			{
				ResourceBundle resource = ResourceBundle.getBundle("config/dbConfig");			
				IP=resource.getString("IP");
				DSN=resource.getString("DSN");
				USR=resource.getString("USERNAME");
				PWD=resource.getString("PWD");		
			    Class.forName("com.mysql.jdbc.Driver");
			    con = DriverManager.getConnection("jdbc:mysql://"+IP+"/"+DSN, USR, PWD);
				System.out.println("Database Connection established!");
				return con;				
			}
			catch(Exception e)
			{
				e.printStackTrace();
				try {
					Thread.sleep(10000);
				} catch (InterruptedException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
		}		
	}
	public static void main(String args[])
	{
		bulkupload bulk = new bulkupload();
		bulk.start();
	}
	public void run()
	{
		try
		  {
		  // Open the file that is the first 
		  // command line parameter
		  FileInputStream fstream = new FileInputStream("/var/www/html/docomo/logs/docomo/capture/EndlessMusic/subscapture_2011-08-19.txt");
		  // Get the object of DataInputStream
		  DataInputStream in = new DataInputStream(fstream);
		  BufferedReader br = new BufferedReader(new InputStreamReader(in));
		  String strLine;
		  //Read File Line By Line
		  while ((strLine = br.readLine()) != null)   
		  {
			  for(int i=0;i<strLine.length();i++)
			  {
			  // Print the content on the console
				arr[i]=java.util.Arrays.toString(strLine.split("#"));	  
				System.out.println (arr[i]);
			  }
		  }
		  
		  //Close the input stream
		  in.close();
		 }
		  catch (Exception e)
		  {//Catch exception if any
			  System.err.println("Error: " + e.getMessage());
		 }
	}
	
	public void readFile()
	{
	  try
	  {
	  // Open the file that is the first 
	  // command line parameter
	  FileInputStream fstream = new FileInputStream("subscapture_2011-08-19.txt");
	  // Get the object of DataInputStream
	  DataInputStream in = new DataInputStream(fstream);
	  BufferedReader br = new BufferedReader(new InputStreamReader(in));
	  String strLine;
	  //Read File Line By Line
	  while ((strLine = br.readLine()) != null)   
	  {
	  // Print the content on the console
	  System.out.println (strLine);
	  }
	  //Close the input stream
	  in.close();
	 }
	  catch (Exception e)
	  {//Catch exception if any
		  System.err.println("Error: " + e.getMessage());
	 }
}
	
	
	
	
	
	
}
