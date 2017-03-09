
package at.jku.student.softwareTech;
import java.util.Random;

public abstract class Animal  {

	Random r = new Random ();
	private int gender = r.nextInt(2);	
	private boolean movement = r.nextBoolean();
	private boolean moved = false;	
	public abstract int getStrength();				/** returns strength of animal */
	public abstract Animal reproduce(int age);	 	/** reproduces an animal with a certain age */
	
	public abstract void setAge(int ages); 			/** sets the age of animal to 'ages' */
	public abstract int getAge();				   	/** returns age of animal */
	public abstract int maxAge();					/** returns maximum age of animal */
	public abstract int getBirthRate(); 			/** returns birth rate of animal */
	public abstract int getBehavior(Animal attacker, Animal defender);	/** returns the reaction of an animal on collision */
	public abstract String toString();				/** state information of animal */
	
	public String getSex(){ /** returns sex of animal */
		String sex;
		if(gender == 0){
			sex = "female";	
		} else{
			sex = "male"; 
		}
		return sex;
	}	
	
	public String getMovement(){ /** returns direction of movement of animal */
		String move;
		if(movement == true){
			move = "forward";
		} else{
			move = "backwards";
		}
		return move;
	}
	
	public void setMoved(boolean move){ /** returns sets an animal to ' moved' */
		moved = move;
	}
	
	public boolean hasMoved(){  /** returns boolean value indicating if an animal has moved*/
		return moved;
	}
}
