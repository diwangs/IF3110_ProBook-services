import org.json.*;
import java.net.*;
import java.io.*;

public class Buku {
	public static void main(String[] args) {
		try{
			URL url = new URL("https://www.googleapis.com/books/v1/volumes?q=" + "harry+potter");
			HttpURLConnection con = (HttpURLConnection) url.openConnection();
			con.setRequestMethod("GET");

			BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
				String inputLine;
				StringBuffer content = new StringBuffer();
				while ((inputLine = in.readLine()) != null) {
				    content.append(inputLine);
				}
			in.close();
			//System.out.println(content);
			con.disconnect();

			JSONObject obj = new JSONObject(content.toString());
			JSONArray arr = obj.getJSONArray("items");
			for (int i = 0; i < arr.length(); i++)
			{
				String bookId = arr.getJSONObject(i).getString("id");
			    String bookTitle = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("title");
			    String bookPublisher = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("publisher");
			    String bookPublishedDate = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("publishedDate");
			    String bookImage = arr.getJSONObject(i).getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
			    String bookDescription = fillBookDescription(arr.getJSONObject(i).getJSONObject("volumeInfo"));
			    
			    System.out.println(i);
			    System.out.println(bookId);
			    System.out.println(bookTitle);
			    System.out.println(bookPublisher);
			    System.out.println(bookPublishedDate);
				System.out.println(bookImage);	
				System.out.println(bookDescription);
				System.out.println();
			}
		} catch	(Exception e) {
			System.out.println(e.getMessage());
		}
	}

	public static String fillBookDescription(JSONObject b) {
		try {
			return b.getString("description");
		} catch (Exception e) {
			return "";
		}
	}	
}