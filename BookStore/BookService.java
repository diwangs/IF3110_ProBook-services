import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

@WebService(targetNamespace="http://bookstore.com/endpoint")
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {

	@WebMethod
	public boolean addBook(Book book);
	
	@WebMethod
	public boolean deleteBook(String id);
	
	@WebMethod
	public Book getBook(String id);
	
	@WebMethod
	public Book[] getAllBooks();
}
