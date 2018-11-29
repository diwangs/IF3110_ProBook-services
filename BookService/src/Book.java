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
	private final static int bookStoreBankId = 0;

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
			System.err.println("Caught an error in retrieveGoogleApi!");
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
				String bookPublishedDate = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"),
						"publishedDate");
				String bookImageUrl = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"), "thumbnail");
				String bookDescription = fillProperties(arr.getJSONObject(i).getJSONObject("volumeInfo"),
						"description");
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

	public static JSONObject createTransaction(int userBankId, int amount) {
		try {
			String url = "http://localhost:3000/api/create_tx";
			URL obj = new URL(url);
			HttpURLConnection con = (HttpURLConnection) obj.openConnection();
			con.setDoOutput(true);
			con.setDoInput(true);
			con.setRequestProperty("Content-Type", "application/json; charset=UTF-8");
			con.setRequestProperty("Accept", "application/json");
			con.setRequestMethod("POST");
			System.out.println("aaa3");

			JSONObject tx = new JSONObject();
			tx.put("sender_id", userBankId);
			tx.put("receiver_id", bookStoreBankId);
			tx.put("amount", amount);
			// Send post request

			OutputStreamWriter wr = new OutputStreamWriter(con.getOutputStream());
			wr.write(tx.toString());
			wr.flush();
			wr.close();

			// get Response
			BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
			String inputLine;
			StringBuffer content = new StringBuffer();
			while ((inputLine = in.readLine()) != null) {
				content.append(inputLine);
			}
			in.close();
			// print result
			System.out.println("" + content.toString());
			con.disconnect();
			return new JSONObject(content.toString());
		} catch (Exception e) {
			System.err.println("Caught an error in createTransaction!");
			System.err.println(e.getMessage());
			return null;
		}
	}

	public static int buyBook(String bookId, int userBankId, int numOfBooks) {
		int bookPrice = getBookPrice(bookId);
		if (bookPrice < 0) {
			System.err.println("Error: Book price not found");
			return 1;
		} else {
			int amount = bookPrice * numOfBooks;
			JSONObject json = createTransaction(userBankId, amount);
			String result = fillProperties(json, "result");
			if (result.compareTo("false") == 0) {
				System.out.println("Error: " + fillProperties(json, "reason"));
				return 1;
			}
			return updateBookSale(bookId, numOfBooks);
		}
	}

	public static int updateBookSale(String bookId, int numOfBooks) {
		try {
			// create our mysql database connection
			String myDriver = "org.gjt.mm.mysql.Driver";
			String myUrl = "jdbc:mysql://localhost/bookstore?autoReconnect=true&useSSL=false";
			Class.forName(myDriver);
			Connection conn = DriverManager.getConnection(myUrl, "root", "12345678");

			PreparedStatement ps = conn.prepareStatement("UPDATE book SET book.sale = book.sale + ? WHERE book.id= ? ");
			ps.setInt(1, numOfBooks);
			ps.setString(2, bookId);
			
			ps.executeUpdate();
			ps.close();
			return 0;
		} catch (Exception e) {
			System.err.println("Got an exception! ");
			System.err.println(e.getMessage());
			return 1;
		}
	}

	private static String fillProperties(JSONObject b, String props) {
		try {
			if (props == "thumbnail")
				b = b.getJSONObject("imageLinks");
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
			Connection conn = DriverManager.getConnection(myUrl, "root", "12345678");

			String query = "SELECT book.price FROM book WHERE book.id='" + bookId + "'";

			Statement st = conn.createStatement();

			ResultSet rs = st.executeQuery(query);

			int bookPrice = -1;

			while (rs.next()) {
				bookPrice = rs.getInt("price");
			}
			st.close();
			return bookPrice;
		} catch (Exception e) {
			System.err.println("Got an exception! ");
			System.err.println(e.getMessage());
			return -2;
		}
	}

	@Override
	public String toString() {
		return id + "\n" + title + "\n" + publisher + "\n" + publishedDate + "\n" + imageUrl + "\n" + description + "\n"
				+ price;
	}
}