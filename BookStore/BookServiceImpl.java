import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.jws.WebService;

// import com.journaldev.jaxws.beans.Person;

@WebService(endpointInterface = "BookService", targetNamespace="http://bookstore.com/endpoint", portName="BookPort", name="Book", serviceName="BookService")
public class BookServiceImpl implements BookService {

	private static Map<String,Book> books = new HashMap<String,Book>();
	
	@Override
	public boolean addBook(Book book) {
		if(books.get(book.getId()) != null) return false;
		books.put(book.getId(), book);
		return true;
	}

	@Override
	public boolean deleteBook(String id) {
		if(books.get(id) == null) return false;
		books.remove(id);
		return true;
	}

	@Override
	public Book getBook(String id) {
		return books.get(id);
	}

	@Override
	public Book[] getAllBooks() {
		Set<String> ids = books.keySet();
		Book[] book = new Book[ids.size()];
		int i=0;
		for(String id : ids){
			book[i] = books.get(id);
			i++;
		}
		return book;
	}

}
