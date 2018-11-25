import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.jws.HandlerChain;
import javax.jws.WebMethod;
import javax.jws.WebService;

//@WebService(endpointInterface = "BookService", targetNamespace="http://bookstore.com/endpoint", portName="BookPort", name="Book", serviceName="BookService")
@WebService(targetNamespace="http://localhost:8888/ws/book")
//@HandlerChain(file="handler-chain.xml")
public class BookServiceMethods {

	private static Map<String,Book> books = new HashMap<String,Book>();
	
	@WebMethod
	public boolean addBook(Book book) {
		if(books.get(book.getId()) != null) return false;
		books.put(book.getId(), book);
		return true;
	}

	@WebMethod
	public boolean deleteBook(String id) {
		if(books.get(id) == null) return false;
		books.remove(id);
		return true;
	}

	@WebMethod
	public Book getBook(String id) {
		return books.get(id);
	}

	@WebMethod
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
