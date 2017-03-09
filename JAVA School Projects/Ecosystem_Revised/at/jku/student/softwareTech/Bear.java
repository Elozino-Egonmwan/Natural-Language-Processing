
package at.jku.student.softwareTech;
import java.util.Random;
	
public class Bear extends Animal{
	
	Random r = new Random ();
	private int maxAge = 9;
	private int age = r.nextInt(maxAge+1);	
	private int birthRate = 2;	
	
	final int FIGHTS = 1;
	final int REPRODUCE = 2;	
	
	public Bear (int ages){
		setAge(ages);
	}
	
	public Animal reproduce(int age){		
		Animal newBorn = new Bear(age);
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
	
	/* generates random strength between 11 - 15 */
	int minStrength = 11;
	int maxStrength = 16;
	private int strength= r.nextInt(maxStrength-minStrength) + minStrength;		
	public int getStrength(){
		return strength;
	}
	
	/* attacker is always Bear */
	public int getBehavior(Animal attacker, Animal defender){
		String combi = "";
		int react = 0;			
		if( (defender.getClass().getSimpleName().equals("Bear"))  && (!(attacker.getSex().equals(defender.getSex()))) ){ 			
			combi = "Bb"; /**Male n Female Bear **/
		}else{
			combi = "B?"; /**otherwise fights with any other animal**/	
		}				
		react = switchAttemptCollide(combi);	
		return react;
	}	
	
	private int switchAttemptCollide(String collision){
		int react = 0;
		switch (collision){
					
			case "Bb" : react = REPRODUCE; /**Bear reproduces **/
						break;					
			case "B?" : react = FIGHTS; /** both fights **/
						break;			
			default:
						System.out.println("Oops something went wrong in Switch case 'switchAttemptCollide'");
						break;
		}
		return react;
	}	
	
	public String toString(){
		if(super.getSex().equals("female"))
			return "b";
		else
			return "B";
	}	
}