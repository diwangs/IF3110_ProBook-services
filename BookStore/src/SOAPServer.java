import javax.xml.ws.Endpoint;

public class SOAPServer {
	public static void main(String[] args) {
        //Book.createBooksUsingJSON(Book.retrieveGoogleApi("harry+potter"));
		Endpoint.publish("http://localhost:8888/ws/book", new BookServiceMethods()); 
		System.out.println("Listening..."); 
	}
}
