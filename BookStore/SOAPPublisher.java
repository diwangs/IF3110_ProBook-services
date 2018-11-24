import javax.xml.ws.Endpoint;

public class SOAPPublisher {

	public static void main(String[] args) {
        Book.createBooksUsingJSON(Book.retrieveGoogleApi("harry+potter"));
		Endpoint.publish("http://localhost:8888/ws/book", new BookServiceImpl());  
	}

}
