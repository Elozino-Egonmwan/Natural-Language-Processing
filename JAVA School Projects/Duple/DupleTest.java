

public class DupleTest{
	public static void main (String args[]){
		Duple duple = new Duple<>(-99.99,0);		
		System.out.println("Signum: \n" + "First: " + duple.signumFirst() + " Second: " + duple.signumSecond());
	}		
}