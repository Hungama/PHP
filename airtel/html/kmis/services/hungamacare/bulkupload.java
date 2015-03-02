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
	public static Statement stmtFM,stmtFM1,stmtFM2,stmtFM3,stmtFM4,stmtDel,stmtupd,stmtBGM,stmtResubInfo;
	public	String DSN="airtel_radio";
	public	String USR="billing";
	public	String PWD="billing";
	public	String IP="10.2.73.156";
	String SubsProcedureName;
	String Lang;
	String Dnis;
	String SubscriptionTable;
	String UnSubscriptionProcedure;
	String UnSubscriptionTable,insertSummaryData;
	String FileName ;
	String AddedOn;
	String ServiceType;
	String Channel;
	int PricePoint;
	String UploadedFor;
	int BatchId;
	int ServiceId;
	String UnubscriptionTable;
	ResultSet rsFile;
	ResultSet rs;
	ResultSet rs1;
						/*String FileName = rsFile.getString("file_name");
						String AddedOn = rsFile.getString("added_on");
						String ServiceType = rsFile.getString("service_type");
						String Channel = rsFile.getString("channel");
						int PricePoint = rsFile.getInt("price_point");
						String UploadedFor = rsFile.getString("upload_for");
						int BatchId = rsFile.getInt("batch_id");
						int ServiceId = rsFile.getInt("service_id");
						*/
	int fileStatus=0;
	int SuccessCount=0;
	int FailureCount=0;
	
	private Connection dbConn()
	{
			try
			{
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
				}
				catch (InterruptedException e1)
				{
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
			return con;

	}
	public static void main(String args[])
	{
		bulkupload bulk = new bulkupload();
		bulk.start();
	}

//===================================================================
	public void run()
	{
		try
		  {
		  con=dbConn();
		  stmtFM1 = con.createStatement();
		  stmtFM3 = con.createStatement();
		  stmtFM = con.createStatement();
		  stmtFM4 = con.createStatement();
		  stmtFM2 = con.createStatement();
		  stmtBGM = con.createStatement();
		  String selectFile="select file_name, added_on, service_type, channel, price_point, upload_for,batch_id,service_id from airtel_radio.bulk_upload_history where status=0 and service_id in(1502,1503,1501,1507) order by added_on desc";
		  System.out.println("before rsFile");
		  rsFile = stmtFM1.executeQuery(selectFile);
		  System.out.println("after rsFile");
		  while(rsFile.next())
		  {
			try
				{

						System.out.println("HERE under while  ");
						FileName = rsFile.getString("file_name");
						AddedOn = rsFile.getString("added_on");
						ServiceType = rsFile.getString("service_type");
						Channel = rsFile.getString("channel");
						PricePoint = rsFile.getInt("price_point");
						UploadedFor = rsFile.getString("upload_for");
						BatchId = rsFile.getInt("batch_id");
						ServiceId = rsFile.getInt("service_id");
						if(fileStatus==0)
						{
							String update_bulk_history="update airtel_radio.bulk_upload_history set status=1 where batch_id="+BatchId+" and service_id="+ServiceId;
							stmtFM.executeUpdate(update_bulk_history);
							fileStatus=1;
						}

						switch(ServiceId)
						{
							case 1501:
								SubsProcedureName="airtel_radio.RADIO_SUB";
								Lang="01";
								Dnis="59090";
								SubscriptionTable="airtel_radio.tbl_radio_subscription";
								UnSubscriptionProcedure="airtel_radio.RADIO_UNSUB";
								UnubscriptionTable="airtel_radio.tbl_radio_unsub";
							break;
							case 1502:
								SubsProcedureName="airtel_hungama.JBOX_SUB";
								Lang="01";
								Dnis="54646";
								SubscriptionTable="airtel_hungama.tbl_jbox_subscription";
								UnSubscriptionProcedure="airtel_hungama.JBOX_UNSUB";
								UnubscriptionTable="airtel_hungama.tbl_jbox_unsub";
							break;
							case 1503:
								SubsProcedureName="airtel_hungama.MTV_SUB";
								Lang="01";
								Dnis="54646";
								SubscriptionTable="airtel_hungama.tbl_mtv_subscription";
								UnSubscriptionProcedure="airtel_hungama.MTV_UNSUB";
								UnSubscriptionTable="airtel_hungama.tbl_mtv_unsub";
							break;
							case 1507:
                                                                SubsProcedureName="airtel_VH1.JBOX_SUB";
                                                                Lang="01";
                                                                Dnis="55481";
                                                                SubscriptionTable="airtel_VH1.tbl_jbox_subscription";
                                                                UnSubscriptionProcedure="airtel_VH1.JBOX_UNSUB";
                                                                UnSubscriptionTable="airtel_VH1.tbl_jbox_unsub";
                                                        break;
						}
						String FileToRead="/var/www/html/kmis/services/hungamacare/bulkuploads/"+ServiceId+"/"+FileName;
						System.out.println(FileToRead);
						File f=new File(FileToRead);
						if(f.exists())
						{
							BufferedReader br = new BufferedReader(new FileReader(f));
							String strLine="";
							String ani,cnt;
							int Amount;

							while ((strLine = br.readLine()) != null)
							{
								System.out.println("inside file read");
								System.out.println(strLine);
								//String arr[]=strLine.split("#");
								if(strLine==null || strLine.equals(""))
								{
									System.out.println("Breaking");
									break;
								}
									String select="select count(*) cnt from "+SubscriptionTable+ " where ani="+strLine;
									System.out.println(select);
									rs = stmtFM4.executeQuery(select);
									System.out.println("after rs");
									if(rs .next())
									{
										System.out.println(strLine);
										cnt = rs.getString("cnt").trim();

										switch (UploadedFor.charAt(0))
										{
											case 'D':
											case 'd':
												if(cnt.equalsIgnoreCase("1"))
												{
													try
													{
														String call="call "+UnSubscriptionProcedure+" ('"+strLine+"','"+Channel+"')" ;
														System.out.println(call);
														CallableStatement stmtcall = con.prepareCall(call);
														stmtcall.execute();
														System.out.println("100");
														SuccessCount++;
													}
													catch (Exception e)
													{
														System.err.println("101: " + e.getMessage());
														FailureCount++;
													}
												}
												else
												{
													System.out.println("102");
												}
												break;
											case 'A':
											case 'a':
												if(cnt.equalsIgnoreCase("0"))
												{
													String plan="select iAmount from master_db.tbl_plan_bank where Plan_id="+PricePoint;
													System.out.println("before rs1");
													rs1 = stmtFM3.executeQuery(plan);
													System.out.println("after rs1");
													if(rs1 .next())
													{
														System.out.println(strLine);
														try
														{
															Amount = rs1.getInt("iAmount");
															String call="call "+SubsProcedureName+" ('"+strLine+"','"+Lang+"','"+Channel+"','"+Dnis+"','"+Amount+"',"+ServiceId+","+PricePoint+")" ;
															System.out.println(call);
															CallableStatement stmtcall = con.prepareCall(call);
															stmtcall.execute();
															System.out.println("100");
															SuccessCount++;
														}
														catch(Exception e){
														System.err.println("101: " + e.getMessage());
														FailureCount++;
													}
											}
										}
									else
									{
										System.out.println("102");
									}
									break;
								}//End of Switch
							}//End of if


					}//While BufferReader Closed
					br.close();
				}//if ends  File
			}
			catch(Exception e1)
			{
			}
			insertSummaryData="insert into billing_intermediate_db.bulk_upload_summary(";
			insertSummaryData +=" batch_id,file_name,channel,service_id,success_count,failure_count)";
			insertSummaryData +=" values('"+BatchId+"','"+FileName+"','"+Channel+"','"+ServiceId+"','"+SuccessCount+"','"+FailureCount+"')";
			stmtFM2.executeUpdate(insertSummaryData);
			fileStatus=0;
		} // End Of While Loop



	}
	catch (Exception e2)
		{//Catch exception if any
			System.err.println("Error: " + e2);
			e2.printStackTrace();
		}
	}
}
