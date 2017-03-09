
package at.jku.student.softwareTech;
import java.util.Random;

public class Fish extends Animal{
	
	Random r = new Random ();
	private int maxAge = 5;
	private int age = r.nextInt(maxAge+1);		
	private int birthRate = 7;	
	
	final int STAY = 0;	
	final int FIGHTS = 1;
	final int REPRODUCE = 2;	
	
	public Fish (int ages){
		setAge(ages);
	}
	
	public Animal reproduce(int age){		
		Animal newBorn = new Fish(age);
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
	/** generates random strength between 3 -5 */
	int minStrength = 3;
	int maxStrength = 6;
	private int strength= r.nextInt(maxStrength-minStrength) + minStrength;		
	public int getStrength(){
		return strength;
	}
	
	/** attacker is always Fish */
	public int getBehavior(Animal attacker, Animal defender){
		String combi = "";
		int react = 0;	
		/** Fish AND any other animal **/
		if ( !(defender.getClass().getSimpleName().equals("Fish")) ) {			
			combi = "F?";			
		}		
		else if( (defender.getClass().getSimpleName().equals("Fish"))  && (!(attacker.getSex().equals(defender.getSex()))) ){ 			
			combi = "Ff"; /**Male n Female Fish **/
		}else{
			combi = "FF"; /**Male n Male or Female n Female Otter **/	
		}		
		react = switchAttemptCollide(combi);		
		return react;
	}	
	
	private int switchAttemptCollide(String collision){
		int react = 0;
		switch (collision){
					
			case "Ff" : react = REPRODUCE; /**Fish Reproduces **/
						break;					
			case "FF" : react = STAY; /** both stays **/
						break;				
			case "F?" : react = FIGHTS; /** both fights **/
						break;			
			default:
						System.out.println("Oops something went wrong in Switch case 'switchAttemptCollide'");
						break;
		}
		return react;
	}	
	
	public String toString(){
		if(super.getSex().equals("female"))
			return "f";
		else
			return "F";
	}	
}