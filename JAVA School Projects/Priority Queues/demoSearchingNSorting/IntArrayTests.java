
import java.util.Arrays;
public class IntArrayTests{
	public static void main (String args[]){
		IntArray arrayInts = new IntArray();	
		for(int i = 15; i >= 0; i--){
			arrayInts.add(i);
		}
		for(int i = 0; i <15; i++){
			arrayInts.add(i);
		}
		for(int i = 0; i <5; i++){
			arrayInts.add(i * -3);
		}
	//arrayInts.dupRem();
	System.out.println(arrayInts.toString());		
	
	}		
}