import org.json.*;
import java.net.*;
import java.io.*;
import java.sql.*;

public class Book implements Serializable {

	private static final long serialVersionUID = -5577579081118070434L;
	private static final String GOOGLEBOOKAPIKEY_STRING = "AIzaSyCvpOMlOt-1GQqe_XYTi3w8XGNfBNVbU-k";
	private static final int BOOKSERVICEBANKID = 0;

	private String id;
	private String title;
	private String[] authors;
	private String imageUrl;
	private String description;
	private String[] categories;
	private int price;

	public Book() {
		id = "";
		title = "";
		authors = null;
		imageUrl = "";
		description = "";
		categories = null;
		price = 0;
	}

	public Book(String id, String title, String[] authors, String imageUrl, String description, String[] categories,
			int price) {
		this.id = id;
		this.title = title;
		this.authors = authors.clone();
		this.imageUrl = imageUrl;
		this.description = description;
		this.categories = categories.clone();
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

	public String[] getAuthors() {
		return authors;
	}

	public void setAuthors(String[] authors) {
		this.authors = authors.clone();
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

	public String[] getCategories() {
		return categories;
	}

	public void setCategories(String[] categories) {
		this.categories = categories.clone();
	}

	public int getPrice() {
		return price;
	}

	public void setPrice(int price) {
		this.price = price;
	}

	public static JSONObject retrieveBookById(String id) {
		try {
			URL url = new URL("https://www.googleapis.com/books/v1/volumes/" + id + "?key=" + GOOGLEBOOKAPIKEY_STRING);
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
			System.err.println("The ID is :" + id + "#");
			System.err.println("Caught an error in retrieveBookById!");
			System.err.println(e.getMessage());
			return null;
		}
	}

	public static JSONObject retrieveBooksByTitle(String title) {
		try {
			URL url = new URL(
					"https://www.googleapis.com/books/v1/volumes?q=" + title + "&key=" + GOOGLEBOOKAPIKEY_STRING);
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
			System.err.println("Caught an error in retrieveBooksByTitle!");
			System.err.println(e.getMessage());
			return null;
		}
	}

	public static Book constructBook(JSONObject json) {
		try {
			String bookId = json.getString("id");
			String bookTitle = json.getJSONObject("volumeInfo").getString("title");
			String[] bookAuthors = new String[0];
			if (json.getJSONObject("volumeInfo").has("authors")) {
				JSONArray authors = json.getJSONObject("volumeInfo").getJSONArray("authors");
				bookAuthors = new String[authors.length()];
				for (int i = 0; i < authors.length(); i++) {
					bookAuthors[i] = authors.getString(i);
				}
			}
			String bookImageUrl = "";
			if (json.getJSONObject("volumeInfo").has("imageLinks")) {
				if (json.getJSONObject("volumeInfo").getJSONObject("imageLinks").has("thumbnail")) {
					bookImageUrl = json.getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail");
				}
			}
			String bookDescription = "";
			if (json.getJSONObject("volumeInfo").has("description")) {
				bookDescription = json.getJSONObject("volumeInfo").getString("description");
			}
			String[] bookCategories = new String[0];
			if (json.getJSONObject("volumeInfo").has("categories")) {
				JSONArray categories = json.getJSONObject("volumeInfo").getJSONArray("categories");
				bookCategories = new String[categories.length()];
				for (int i = 0; i < categories.length(); i++) {
					bookCategories[i] = categories.getString(i);
				}
			}
			int bookPrice = getBookPrice(bookId);
			Book book = new Book(bookId, bookTitle, bookAuthors, bookImageUrl, bookDescription, bookCategories,
					bookPrice);
			return book;
		} catch (Exception e) {
			System.err.println("Error!!!! " + e.getMessage());
			return new Book();
		}
	}

	public static Book[] constructBooks(JSONObject json) {
		try {
			if (json.has("items")) {
				JSONArray arr = json.getJSONArray("items");
				Book[] books = new Book[arr.length()];
				for (int i = 0; i < arr.length(); i++) {
					Book book = constructBook(arr.getJSONObject(i));
					books[i] = book;
				}
				return books;
			}
			return new Book[0];
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
			tx.put("receiver_id", BOOKSERVICEBANKID);
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
			String myDriver = "org.gjt.mm.mysql.Driver";
			String myUrl = "jdbc:mysql://localhost/bookservice?autoReconnect=true&useSSL=false";
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

	public static int getBookPrice(String bookId) {
		try {
			String myDriver = "org.gjt.mm.mysql.Driver";
			String myUrl = "jdbc:mysql://localhost/bookservice?autoReconnect=true&useSSL=false";
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

	private static String fillProperties(JSONObject b, String props) {
		try {
			if (props == "thumbnail")
				b = b.getJSONObject("imageLinks");
			return b.getString(props);
		} catch (Exception e) {
			return "";
		}
	}

	@Override
	public String toString() {
		return id + "\n" + title + "\n" + authors + "\n" + imageUrl + "\n" + description + "\n" + categories + "\n"
				+ price;
	}
}