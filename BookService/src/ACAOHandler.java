import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.annotation.Resource;
import javax.xml.namespace.QName;
import javax.xml.ws.WebServiceContext;
import javax.xml.ws.handler.MessageContext;
import javax.xml.ws.handler.soap.SOAPHandler;
import javax.xml.ws.handler.soap.SOAPMessageContext;

public class ACAOHandler implements SOAPHandler<SOAPMessageContext> {
    @Resource
    private WebServiceContext ctx;

    @Override
    public boolean handleMessage(SOAPMessageContext context) {
        MessageContext mc = ctx.getMessageContext();
		Map<String, Object> resHeaders = new HashMap<String, Object>();
		resHeaders.put("Access-Control-Allow-Origin", "*");
		mc.put("HTTP_RESPONSE_HEADERS", resHeaders);
        return true;
    }

    @Override
	public Set<QName> getHeaders() {
		System.out.println("Server : getHeaders()......");
		return null;
    }
    
    @Override
	public void close(MessageContext context) {
		System.out.println("Server : close()......");
    }
    
    @Override
	public boolean handleFault(SOAPMessageContext context) {
		System.out.println("Server : handleFault()......");
		return true;
	}
}