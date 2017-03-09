
package at.jku.student.softwareTech;
import java.util.Random;

public class Zombie extends Animal{
	
	Random r = new Random ();
	private int maxAge = 3;
	private int age = r.nextInt(maxAge+1);	
	private int birthRate = 4;	
	
	final int STAY = 0;	
	final int FIGHTS = 1;
	final int REPRODUCE = 2;	
	
	public Zombie (int ages){
		setAge(ages);
	}
	
	public Animal reproduce(int age){		
		Animal newBorn = new Zombie(age);
		return newBorn;		
	}
	
	public void setAge(int ages){
		if (ages <= maxAge){
			age = ages;
		} else{
			System.out.println(ages + " is higher than maximum age of an Zombie, hence it has been reset to " + age);			
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
	
	/** generates random strength between 0 -2 */
	int minStrength = 0;
	int maxStrength = 3;
	private int strength= r.nextInt(maxStrength-minStrength) + minStrength;		
	public int getStrength(){
		return strength;
	}
	
	/**Attacker is always Zombie */
	public int getBehavior(Animal attacker, Animal defender){
		String combi = "";
		int react = 0;
		
		/** Zombie AND Any other animal **/
		if ( !(defender.getClass().getSimpleName().equals("Zombie") )) {			
			combi = "Z?";			
		}	
		else if( (defender.getClass().getSimpleName().equals("Zombie"))  && (!(attacker.getSex().equals(defender.getSex()))) ){ 			
			combi = "Zz"; /**Male n Female Zombie **/
		}else{
			combi = "ZZ"; /**Male n Male or Female n Female Zombie **/	
		}
			
		react = switchAttemptCollide(combi);		
		return react;
	}	
	
	private int switchAttemptCollide(String collision){
		int react = 0;
		switch (collision){
					
			case "Zz" : react = REPRODUCE; /**Zombie Reproduces **/
						break;					
			case "ZZ" : react = STAY; /** both stays **/
						break;				
			case "Z?" : react = FIGHTS; /** Zombie fights **/
						break;			
			default:
						System.out.println("Oops something went wrong in Switch case 'switchAttemptCollide'");
						break;
		}
		return react;		
	}	
	
	public String toString(){
		if(super.getSex().equals("female"))
			return "z";
		else
			return "Z";
	}	
}