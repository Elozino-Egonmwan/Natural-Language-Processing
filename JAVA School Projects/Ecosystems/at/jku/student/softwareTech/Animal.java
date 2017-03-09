
package at.jku.student.softwareTech;
import java.util.Random;

public abstract class Animal  {

	Random r = new Random ();
	private int gender = r.nextInt(2);
	private int strength = r.nextInt(10);
	private boolean movement = r.nextBoolean();
	private boolean moved = false;	
	
	public abstract void setAge(int ages);
	public abstract int getAge();
	public abstract int maxAge();	
	public abstract int getBirthRate();
	public abstract String toString();	
	
	public String getSex(){
		String sex;
		if(gender == 0){
			sex = "female";	
		} else{
			sex = "male"; 
		}
		return sex;
	}	
	
	public int getStrength(){
		return strength;
	}
	
	public String getMovement(){
		String move;
		if(movement == true){
			move = "forward";
		} else{
			move = "backwards";
		}
		return move;
	}
	
	public void setMoved(boolean move){
		moved = move;
	}
	
	public boolean hasMoved(){
		return moved;
	}
}
