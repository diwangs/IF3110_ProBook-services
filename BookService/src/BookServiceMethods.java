import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.jws.HandlerChain;
import javax.jws.WebMethod;
import javax.jws.WebService;

@WebService(endpointInterface="BookServiceInterface", targetNamespace="http://localhost:8888/ws/book", portName="BookPort", name="Book", serviceName="BookService")
//@HandlerChain(file="handler-chain.xml")
public class BookServiceMethods implements BookServiceInterface {

	@Override
	public Book getBookById(String id) {
		return Book.constructBook(Book.retrieveBookById(id));
	}

	@Override
	public Book[] getBooksByTitle(String title) {
		return Book.constructBooks(Book.retrieveBooksByTitle(title.replace(" ", "+")));
	}

	@Override
	public boolean buyBook(String bookId, int userBankId, int numOfBooks) {
		return Book.buyBook(bookId, userBankId, numOfBooks) == 0;
	}

}
