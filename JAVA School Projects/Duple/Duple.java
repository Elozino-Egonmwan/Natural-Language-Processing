
import java.lang.*;
public class Duple <T1 extends Number,T2 extends Number> implements Signum{
	private T1 firstNum;
	private T2 secondNum;
		
	public Duple (T1 first, T2 second){	
		firstNum = first;
		secondNum = second;
	}
	
	/** sets the first number*/
	public void setFirst(T1 first){
		firstNum = first;
	}
	
	/** sets the second number */
	public void setSecond(T2 second){
		secondNum = second;
	}
	
	/** returns the first number */
	public T1 getFirst(){
		return firstNum;
	}
	
	/** returns the second number */
	public T2 getSec(){
		return secondNum;
	}
	
	public int signumFirst(){		
		double n = firstNum.doubleValue();
		return (int) Math.signum(n);		
	}
	
	public int signumSecond(){
		double n = secondNum.doubleValue();
		return (int) Math.signum(n);
	}
}