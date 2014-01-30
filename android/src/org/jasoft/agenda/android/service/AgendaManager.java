package org.jasoft.agenda.android.service;

import java.io.IOException;
import java.io.InputStream;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.entity.InputStreamEntity;
import org.apache.http.impl.client.DefaultHttpClient;

public class AgendaManager {

//	private static String URL="http://localhost:5678/sil/";
	private static String URL="http://localhost:5678/sil/rest/security/listAllowedMenus.htm";
	
	public AgendaManager() {
		
	}
	
	public String getContactList() {
		HttpClient c=new DefaultHttpClient();
		HttpGet get=new HttpGet(URL);
		
		try {
			HttpResponse r=c.execute(get);
			HttpEntity he=r.getEntity();
			InputStream is=he.getContent();
			
			byte[] buffer=new byte[1024];
			int readLength=0;
			while (is.read(buffer)>0) {
				
			}
			
		} catch (ClientProtocolException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	
}
