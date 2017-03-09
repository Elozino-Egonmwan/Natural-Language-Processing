
import java.util.Random;
import java.util.Arrays;
import java.lang.*;
public class PQTest{
	public static void main (String args[]){
		Priority_Queue pq = new Priority_Queue(15);
		Random r = new Random ();
		for(int i = 15; i > 0; i-- ){
			pq.insert(i);			
		}	
		
		for(int i = 0; i < 5; i++ ){
			System.out.print(pq.remove() + " ");
			//pq.remove();
		}
		System.out.println(pq.toString());	
		
	}		
}