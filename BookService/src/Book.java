import org.json.*;
import java.net.*;
import java.io.*;
import java.sql.*;

public class Book implements Serializable {

	private static final long serialVersionUID = -5577579081118070434L;

	private String id;
	private String title;
	private String publisher;
	private String publishedDate;
	private String imageUrl;
	private String description;
	private int price;

	public Book() {
		id = "";
		title = "";
		publisher = "";
		publishedDate = "";
		imageUrl = "";
		description = "";
		price = 0;
	}

	public Book(String id, String title, String publisher, String publishedDate, String imageUrl, String description,
			int price) {
		this.id = id;
		this.title = title;
		this.publisher = publisher;
		this.publishedDate = publishedDate;
		this.imageUrl = imageUrl;
		this.description = description;
		this.price = price;
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getPublisher() {
		return publisher;
	}

	public void setPublisher(String publisher) {
		this.publisher = publisher;
	}

	public String getPublishedDate() {
		return publishedDate;
	}

	public void setPublishedDate(String publishedDate) {
		this.publishedDate = publishedDate;
	}

	public String getImageUrl() {
		return imageUrl;
	}

	public void setImageUrl(String imageUrl) {
		this.imageUrl = imageUrl;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public int getPrice() {
		return price;
	}

	public void setPrice(int price) {
		this.price = price;
	}

	public static JSONObject retrieveGoogleApi(String volume) {
		try {
			URL url = new URL("https://www.googleapis.com/books/v1/volumes?q=" + volume);
			HttpURLConnection con = (HttpURLConnection) url.openConnection();
			con.setRequestMethod("GET");

			BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
			String inputLine;
			StringBuffer content = new StringBuffer();
			while ((inputLine = in.readLine()) != null) {
				content.append(inputLine);
			}
			in.close();
			con.disconnect();
			return new JSONObject(content.toString());
		} catch (Exception e) {
			System.err.println("Caught an error!");
			System.err.println(e.getMessage());
			return null;
		}
	}

	public static Book[] createBooksUsingJSON(JSONObject json) {
		try {
			JSONArray arr = json.getJSONArray("items");
			Book[] books = new Book[arr.length()];
			for (int i = 0; i < arr.length(); i++) {
				String bookId = fillProperties(arr.getJSONObject(i), "id");
				String bookTitle = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "title");
				String bookPublisher = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "publisher");
				String bookPublishedDate = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "publishedDate");
				String bookImageUrl = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "thumbnail");
				String bookDescription = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "description");
				int bookPrice = getBookPrice(bookId);
				
				Book book = new Book(bookId, bookTitle, bookPublisher, bookPublishedDate, bookImageUrl, bookDescription,
				bookPrice);
				books[i] = book;
				
				System.out.println(book);
				System.out.println();
			}
			return books;
		} catch (Exception e) {
			return new Book[0];
		}
	}

	@Override
	public String toString() {
		return id + "\n" + title + "\n" + publisher + "\n" + publishedDate + "\n" + imageUrl + "\n" + description + "\n"
				+ price;
	}

	// public static void main(String[] args) {
		// try {
			// URL url = new URL("https://www.googleapis.com/books/v1/volumes?q=" +
			// "harry+potter");
			// HttpURLConnection con = (HttpURLConnection) url.openConnection();
			// con.setRequestMethod("GET");

			// BufferedReader in = new BufferedReader(new
			// InputStreamReader(con.getInputStream()));
			// String inputLine;
			// StringBuffer content = new StringBuffer();
			// while ((inputLine = in.readLine()) != null) {
			// content.append(inputLine);
			// }
			// in.close();
			// // System.out.println(content);
			// con.disconnect();

		// 	JSONObject obj = new JSONObject(content.toString());
		// 	JSONArray arr = obj.getJSONArray("items");
		// 	for (int i = 0; i < arr.length(); i++) {
		// 		String bookId = arr.getJSONObject(i).getString("id");
		// 		String bookTitle = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("title");
		// 		String bookPublisher = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("publisher");
		// 		String bookPublishedDate = arr.getJSONObject(i).getJSONObject("volumeInfo").getString("publishedDate");
		// 		String bookImage = arr.getJSONObject(i).getJSONObject("volumeInfo").getJSONObject("imageLinks")
		// 				.getString("thumbnail");
		// 		String bookDescription = fillBookDescription(arr.getJSONObject(i).getJSONObject("volumeInfo"));
		// 		String bookPrice = String.valueOf(getBookPrice(bookId));
		// 		if (bookPrice.equals("-1")) {
		// 			bookPrice = "Not For Sale";
		// 		}

		// 		System.out.println(i);
		// 		System.out.println(bookId);
		// 		System.out.println(bookTitle);
		// 		System.out.println(bookPublisher);
		// 		System.out.println(bookPublishedDate);
		// 		System.out.println(bookImage);
		// 		System.out.println(bookDescription);
		// 		System.out.println(bookPrice);
		// 		System.out.println();
		// 	}
		// } catch (Exception e) {
		// 	System.out.println(e.getMessage());
		// }
	// }

	private static String fillProperties(JSONObject b, String props) {
		try {
			if (props == "thumbnail") b = b.getJSONObject("imageLinks");
			return b.getString(props);
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
			Connection conn = DriverManager.getConnection(myUrl, "root", "");

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