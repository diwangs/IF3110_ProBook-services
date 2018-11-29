import javax.jws.HandlerChain;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

@WebService(targetNamespace="http://localhost:8888/ws/book")
@SOAPBinding(style = SOAPBinding.Style.RPC)
//@HandlerChain(file="handler-chain.xml")
public interface BookServiceInterface {

	@WebMethod
	public Book getBookById(String id);
	
	@WebMethod
	public Book[] getBooksByTitle(String title);

	@WebMethod
	public boolean buyBook(String bookId, int userBankId, int numOfBooks);
}