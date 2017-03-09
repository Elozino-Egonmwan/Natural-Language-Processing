
/**
 * Simple priority queue implementation in Java.
 * 
 * @author Elozino Ofualagba
 */
import java.lang.*;
import java.util.Objects;
import java.util.Arrays;
public class Priority_Queue<T extends Comparable<T>>{
	private Object[] q;
	private int maxSize;	
	private int size;
	private int front = -1;
	private int rear = -1;

	/**
	 * Instantiates a priority queue of the given maximum size.
	 */
	public Priority_Queue(int maxSize) {
		this.maxSize = maxSize;
		this.q = new Object[maxSize];	
		size = maxSize;
	}
		
	/** Insert an item into the priority queue at the rear.  */	
	public void insert(T item){
        q[(++rear) % q.length] = item;
		if(front == - 1)
			front = 0;		
	}

	/** Remove the item with highest priority from the front*/	
	public T remove(){		
		T minValue =  (T) q[front];
		int minPos = front;
		int start;
		if ( isEmpty() ){
			Integer x = 1;
			return (T) x;
		}
		else if (front == rear){ /** last item in queue (front == rear)*/			
			front = rear = -1;			
			return (T) q[minPos];
		}
		else{
			start  = (front + 1) % size;			
		}
		/**find smallest value */
		for (int i = start; i <= rear; i++){			
			if (((T)q[i]).compareTo(minValue) < 0){ /** q[i] < minValue */
				minValue = (T)q[i];	
				minPos = i;
			}
		}		
		shiftQueue(minPos);				
		return (T) minValue;
	}
	
	/** reorder queue after removal **/
	public void shiftQueue(int minPos){ 
		if(minPos == rear)
			rear--;		
		if(minPos == front) /**elemnt at the front */
			front++;
		else{
			for(int i = minPos; i < rear; i++)
				q[i] = q[i+1];						
		}		
	}

	/** The number of elements in the queue	 */
	public int size() {
		return rear - front;
	}	
	
	public boolean isFull() {
		return size() == q.length;
	}
	
	public boolean isEmpty(){
		return ( (front == -1) && (rear == -1) );		
	}	
	
	public String toString(){		
		String s = "\n";
		for(int i = 0; i <=size(); i++){
			s += q[i]+ " ";
		}
		return s;		
	}
}
