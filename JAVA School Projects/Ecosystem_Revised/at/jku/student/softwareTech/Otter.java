
package at.jku.student.softwareTech;
import java.util.Random;

public class Otter extends Animal{
	
	Random r = new Random ();
	private int maxAge = 7;
	private int age = r.nextInt(maxAge+1);	
	private int birthRate = 3;	
	
	final int STAY = 0;	
	final int FIGHTS = 1;
	final int REPRODUCE = 2;	
	
	public Otter (int ages){
		setAge(ages);
	}
	
	public Animal reproduce(int age){		
		Animal newBorn = new Otter(age);
		return newBorn;		
	}
	
	public void setAge(int ages){
		if (ages <= maxAge){
			age = ages;
		} else{
			System.out.println(ages + " is higher than maximum age of an Otter, hence it has been reset to " + age);			
		}
	}
	
	public int getAge (){
		return age;
	}
	
	public int maxAge(){
		return maxAge;
	}
	
	public int getBirthRate(){
		return birthRate;
	}
	
	/** generates random strength between 6 -10 */
	int minStrength = 6;
	int maxStrength = 11;
	private int strength= r.nextInt(maxStrength-minStrength) + minStrength;		
	public int getStrength(){
		return strength;
	}
	
	/**Attacker is always Otter */
	public int getBehavior(Animal attacker, Animal defender){
		String combi = "";
		int react = 0;
		
		/** Otter AND Any other animal **/
		if ( !(defender.getClass().getSimpleName().equals("Otter") )) {			
			combi = "O?";			
		}	
		else if( (defender.getClass().getSimpleName().equals("Otter"))  && (!(attacker.getSex().equals(defender.getSex()))) ){ 			
			combi = "Oo"; /**Male n Female Otter **/
		}else{
			combi = "OO"; /**Male n Male or Female n Female Otter **/	
		}
			
		react = switchAttemptCollide(combi);		
		return react;
	}	
	
	private int switchAttemptCollide(String collision){
		int react = 0;
		switch (collision){
					
			case "Oo" : react = REPRODUCE; /**Otter Reproduces **/
						break;					
			case "OO" : react = STAY; /** both stays **/
						break;				
			case "O?" : react = FIGHTS; /** Otter fights **/
						break;			
			default:
						System.out.println("Oops something went wrong in Switch case 'switchAttemptCollide'");
						break;
		}
		return react;		
	}	
	
	public String toString(){
		if(super.getSex().equals("female"))
			return "o";
		else
			return "O";
	}	
}