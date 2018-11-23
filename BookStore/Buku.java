import org.json.*;
import java.net.*;
import java.io.*;
import java.sql.*;

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
				String bookPrice = String.valueOf(getBookPrice(bookId));
				if (bookPrice.equals("-1")) {
					bookPrice = "Not For Sale";
				}
				
			    System.out.println(i);
			    System.out.println(bookId);
			    System.out.println(bookTitle);
			    System.out.println(bookPublisher);
			    System.out.println(bookPublishedDate);
				System.out.println(bookImage);	
				System.out.println(bookDescription);
				System.out.println(bookPrice);
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

	public static int getBookPrice(String bookId) {
		try {
            // create our mysql database connection
            String myDriver = "org.gjt.mm.mysql.Driver";
            String myUrl = "jdbc:mysql://localhost/bookstore?autoReconnect=true&useSSL=false";
            Class.forName(myDriver);
            Connection conn = DriverManager.getConnection(myUrl, "root", "1234");

            // our SQL SELECT query.
            // if you only need a few columns, specify them by name instead of using "*"
			String query = "SELECT bookprice FROM book WHERE book.bookid='" + bookId + "'";

            // create the java statement
            Statement st = conn.createStatement();

            // execute the query, and get a java resultset
            ResultSet rs = st.executeQuery(query);

            // iterate through the java resultset
			
			int bookPrice = -1;

			while (rs.next()) {
                bookPrice = rs.getInt("bookprice");
            }
			st.close();
			return bookPrice;
        } catch (Exception e) {
            System.err.println("Got an exception! ");
			System.err.println(e.getMessage());
			return -2;
		}
	}
}