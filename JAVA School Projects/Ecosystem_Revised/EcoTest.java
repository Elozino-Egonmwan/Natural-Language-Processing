import java.util.Arrays;
import at.jku.student.softwareTech.*;

public class EcoTest{
	public static void main (String args[]){
		EcoSystem ecys = new River (200);
		Animal[] animals = new Animal[200];		
		/** add 30 bears of age 3 */
		Animal bear = new Bear (3);
		animals = ecys.addAnimal (bear, 30);
		
		/**add 70 otters of age 8 */
		Animal otter = new Otter (8);
		animals = ecys.addAnimal(otter,70);
		
		/**add 40 fishes of age 4 */
		Animal fish = new Fish (4);		
		animals = ecys.addAnimal(fish,40);
		
		/**add 60 Zombies of age 2 */
		Animal zombie = new Zombie (2);
		animals = ecys.addAnimal(zombie,60);		
		
		System.out.println("Before Simulation");
		System.out.println(ecys.toCompactString());		
		animals = ecys.simulate(5);
		System.out.println("After Simulation");
		System.out.println(ecys.toString());
		System.out.println(ecys.toCompactString());			
	}	
	
}