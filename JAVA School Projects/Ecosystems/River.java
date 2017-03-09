import at.jku.student.softwareTech.*;
import java.util.Arrays;
import java.util.Random;

/** ECOSYSTEM written by Elozino OFUALAGBA
**	March 27, 2015
** 	Simulates the existence of 3 animal species, OTTER, BEAR n FISH in a river
**/
public class River implements EcoSystem{
	private int population;
	private Animal[] river;	
	private Random r = new Random ();
	
	final int STAY = 0;
	final int BEAR_REPRODUCE = 2;
	final int OTTER_REPRODUCE = 3;
	final int FISH_REPRODUCE = 7;
	final int BEAR_FIGHTS = -1;
	final int BEAR_WINS = -2;
	final int OTTER_WINS = -3;
	final int FREE = -4;
	
	public River(int size ){			
		population = size;
		river = new Animal[size];
	}
		
	/** public entry to private method addTo, performs all checks before adding animal**/
	public Animal[] addAnimal (Animal specie, int number){		
		int space = free();
		int addAnim = 0;
		Class specClass;		
		int specieCnt = 0;
		int canAdd = 0;
		int add = 0;
		int age = specie.getAge();
		String specieClass = specie.getClass().getSimpleName(); /** get type of animal as a simple string **/
		if(space > 0){
			if(space >= number)	
				addAnim = number;
			if(space < number)
				addAnim = space;
			specClass = getSpecieClass(specie); /** get type of Animal	**/
			specieCnt = specieCount(specClass); /** get number of Animals of that specific type **/
			canAdd = canAddSpecie(specieCnt);  /** how many more animals of this type can we add? **/
			if(canAdd >= addAnim)	
				add = addAnim;
			if(canAdd < addAnim)
				add = canAdd;
			if (add > 0){
				river = addTo(specieClass,add,age);
			}else{
				/**System.out.println("No more space in Ecosystem for " + number + " " + specieClass);**/
			}
		}else{
			/**System.out.println("Sorry cannot add " + number + " more " + specieClass + " EcoSystem is full");**/
		}
		return river;
	}
	
	/** actually adds a specific number of specified animal types or species **/
	private Animal[] addTo(String specie, int number, int age){		
		Animal newAnim;
		int freeCell = r.nextInt(population); /** generate a random cell **/
		for(int i = 0; i < number; i++){
			if(specie.equals("Fish")){
				newAnim = new Fish(age) ;
			} else if (specie.equals("Bear")){
				newAnim = new Bear(age) ;
			}else{
				newAnim = new Otter(age) ;
			}			
			while(isFreeCell(freeCell) == false){
				freeCell = r.nextInt(population);
			}
			river[freeCell] = newAnim;			
		}
		return river;		
	}
	
	public Animal[] simulate(int rounds){
		String direction;
		Animal attacker,defender = null; 
		int react, posAttacker, posDefender;
		for (int sim = 0; sim < rounds; sim++){					
			for (int i = 0; i < population; i++){
				attacker = river[i];
				posAttacker = i;
				if((attacker != null) && (attacker.hasMoved() == false)){
					direction = attacker.getMovement();
					if (direction.equals("forward")){ /** forward movement **/
						if(i == population - 1){ /**ensuring animal does not move out of array	**/									
							defender = river[0];						
							posDefender = 0;
						} else{						
							defender = river[i+1];							
							posDefender = i+1;
						} 
					}else{ /** backward movement  **/
						if(i== 0){ /** ensuring animal does not move out of array	**/					
							defender = river[population -1];						
							posDefender = population - 1;
						}
						else{						
							defender = river[i-1];						
							posDefender = i-1;
						}
					}				
					react = Behavior(attacker, defender); /** attempt movement **/					
					river = switchMove(react,attacker,defender, posAttacker, posDefender); /**implement movement **/
					if (attacker != null){   /** if animal has not been killed already **/
						attacker.setMoved(true);
						if (attacker.getAge() == attacker.maxAge()){
							attacker = null; /**dies **/							
						}else{
							attacker.setAge(attacker.getAge() + 1);
						}
					}					
				}
			}
			/** at the end of a round(simulation) , every living animal is reset to move again freely**/
			river = resetMovement(river);
		}		
		return river;
	}
	
	private Animal[] switchMove(int react, Animal attacker, Animal defender, int posAttacker, int posDefender){
		switch (react){
			case STAY : /** no movement	no extra side reactions	**/						
				break;					
			case BEAR_FIGHTS : /**Bear n Bear of same gender stronger stays, weaker dies **/
				if(attacker.getStrength() >= defender.getStrength()){ /** moves and kills **/
					defender = null; /** defender is killed **/
					river[posAttacker] = defender;
					river[posDefender] = attacker; /** move to the position of defender	 **/														
				} else if(attacker.getStrength() < defender.getStrength()){ /** killed without moving **/
					attacker = null; /** attacker is killed **/
					river[posAttacker] = attacker;
				}							
				break;			
			case BEAR_WINS :  /** Bear and Fish or Otter **/
				if(attacker.getClass().getSimpleName().equals("Bear")) { /** attacker takes over **/
					defender = null; /** fish or otter is attacked, killed n taken over **/
					river[posAttacker] = defender;
					river[posDefender] = attacker;
				} else{  /** Bear attacked, just wins, but does not swap position **/
					attacker = null; /** fish or otter attacks, but is killed **/
					river[posAttacker] = attacker;
				}
				break;					
			case OTTER_WINS : /** Otter and Fish ; Otter eats fish **/
				if(attacker.getClass().getSimpleName().equals("Otter")) { /** attacker takes over **/
					defender = null; /** fish is attacked, killed n taken over **/
					river[posAttacker] = defender;
					river[posDefender] = attacker;
				} else{  /** Otter attacked, just wins, but does not swap position **/
					attacker = null; /** fish attacks, but is killed **/
					river[posAttacker] = null;
				}
				break;	
			case BEAR_REPRODUCE : /** Bear Reproduction **/
				Animal bear = new Bear(0);
				river = addAnimal (bear, BEAR_REPRODUCE);
				break;	
			case OTTER_REPRODUCE : /** Otter Reproduction **/
				Animal otter = new Otter(0);
				river = addAnimal (otter, OTTER_REPRODUCE);							
				break;	
			case FISH_REPRODUCE : /** Fish Reproduction **/
				Animal fish = new Fish(0);
				river = addAnimal (fish, FISH_REPRODUCE);							
				break;
			case FREE : /** Adjacent free cell simple just move **/
				river[posAttacker] = null;
				river[posDefender] = attacker;
				break;
			default:
				System.out.println("Oops something went wrong in Switch case 'Reaction'");
				break;
		}
		return river;
	}
	
	private Animal[] resetMovement(Animal[] animals){
		for(int i = 0; i < animals.length; i++){
			if(animals[i] != null){ /** if animal has not been killed already, then it can move again **/
				animals[i].setMoved(false);
			}
		}
		return animals;
	}
	
	public int Behavior(Animal attacker, Animal defender){
		String combi = "";
		int react = 0;
		/**Adjacent cell is free, easy  just move **/
		if((attacker == null) || (defender == null)){
			combi = "??";
		} else{
			if((attacker.getClass().getSimpleName().equals("Fish")) && (defender.getClass().getSimpleName().equals("Fish"))){ /** Fish AND Fish **/
				if(((attacker.getSex().equals("male")) && (defender.getSex().equals("female"))) 
					|| ((attacker.getSex().equals("female")) && (defender.getSex().equals("male")))){ /**Male n Female Fish **/
						combi = "Ff";
				}else{
					combi = "FF"; /**Male n Male or Female n Female Fish **/	
				}
			} else if ((attacker.getClass().getSimpleName().equals("Otter")) && (defender.getClass().getSimpleName().equals("Otter"))){ /** Otter AND Otter **/
				if(((attacker.getSex().equals("male")) && (defender.getSex().equals("female")))
					|| ((attacker.getSex().equals("female")) && (defender.getSex().equals("male")))){ /**Male n Female Otter **/
						combi = "Oo";
				}else{
					combi = "OO"; /**Male n Male or Female n Female Otter **/	
				}		
			} else if ((attacker.getClass().getSimpleName().equals("Bear")) && (defender.getClass().getSimpleName().equals("Bear"))){ /** Bear AND Bear **/
				if(((attacker.getSex().equals("male")) && (defender.getSex().equals("female")))
					|| ((attacker.getSex().equals("female")) && (defender.getSex().equals("male")))){ /**Male n Female Bear **/
						combi = "Bb";
				}else{
					combi = "BB"; /**Male n Male or Female n Female Bear **/
				}
			} else if (((attacker.getClass().getSimpleName().equals("Bear")) && !(defender.getClass().getSimpleName().equals("Bear")))
				   || (!(attacker.getClass().getSimpleName().equals("Bear")) && (defender.getClass().getSimpleName().equals("Bear")))){ /** Bear AND any other animal **/			
						combi = "B?";			
			} else if (((attacker.getClass().getSimpleName().equals("Otter")) && (defender.getClass().getSimpleName().equals("Fish")))
				   || ((attacker.getClass().getSimpleName().equals("Fish")) && (defender.getClass().getSimpleName().equals("Otter")))){ /** Otter AND Fish **/
						combi = "OF";			
			}
		}		
		react = switchAttemptCollide(combi, attacker);		
		return react;	
	}	
	
	private int switchAttemptCollide(String collision, Animal attacker){
		int react = 0;
		switch (collision){
			case "Ff" : react = attacker.getBirthRate(); /**getBirthRate of Fish **/
						break;					
			case "FF" : react = STAY; /** both stays **/
						break;			
			case "Oo" : react = attacker.getBirthRate(); /**getBirthRate of Otter **/
						break;					
			case "OO" : react = STAY; /** both stays **/
						break;	
			case "Bb" : react = attacker.getBirthRate(); /**getBirthRate of Bear **/
						break;
			case "BB" : react = BEAR_FIGHTS; /** both fights **/
						break;
			case "B?" : react = BEAR_WINS; /** Bear wins **/
						break;
			case "OF" : react = OTTER_WINS; /** Otter wins **/
						break;
			case "??" : react = FREE; /** adjacent cell is free **/
						break;
			default:
						System.out.println("Oops something went wrong in Switch case 'switchAttemptCollide'");
						break;
		}
		return react;
	}
	
	/**  Returns number of animals in EcoSystem **/
	public int livingEco(){
		int livingCount = 0;
		for (int i = 0; i < population; i++){
			if ((river[i] instanceof Fish ) || (river[i] instanceof Bear ) || (river[i] instanceof Otter )){
				livingCount++;
			}			
		}
		return livingCount;
	}
	
	/** Returns number of free cells **/
	public int free(){
		int occupied = livingEco();
		return population - occupied;
	}
	
	/** Counts the number of animals of a particular type **/
	public int specieCount(Class specie){
		int count = 0;
		for(Animal elem : river)
			count += (specie.isInstance(elem)) ? 1 : 0;
		return count;		
	}
	
	/**Returns how many more animals of a particular type can be added **/
	public int canAddSpecie(int existing){
		int max = (int) (0.6 * population);
		int addSpecie = 0;
		if(existing == max){
			addSpecie = 0;
		} else{
			addSpecie = max - existing;
		}
		return addSpecie;
	}
	
	/** checks if a cell is free **/
	public boolean isFreeCell(int cell){
		if ((river[cell] instanceof Fish ) || (river[cell] instanceof Bear ) || (river[cell] instanceof Otter )){
			return false;
		}
		return true;
	}	
	
	/** Returns type of Animal **/
	public Class getSpecieClass(Animal specie){
		Class clazz = Fish.class;
		if(specie instanceof Fish){
			clazz = Fish.class;
		} else if (specie instanceof Bear){
			clazz = Bear.class;
		} else if (specie instanceof Otter){
			clazz = Otter.class;
		}
		return clazz;
	}	
	
	/** prints state information of each animal**/
	public String toString(){
		String info= "";
		for (int i = 0; i< population; i++){
			if(river[i] != null){
				String name = river[i].getClass().getSimpleName();
				String label = river[i].toString();
				String gend = river[i].getSex();		
				int mat = river[i].getAge();
				int vigor = river[i].getStrength();
				int birth = river[i].getBirthRate();
				String direction = river[i].getMovement();				
				info += "\n" + river[i];				
				info += "\n -Type: " + name + "; Gender: " + gend + "; Label: " + label + "; Age: " + mat + "; Birth Rate: " + birth;
				info += "\n Strength: " + vigor + "; Direction: " + direction;				
			}else{			
				info += "\nNo Animal";
			}			
		}
		return info;
	}
	
	/**Prints compact state of EcoSystem **/
	public String toCompactString(){		
		String outputRiver = "\n";
		int countAnimals = livingEco();
		int specieFish = specieCount(Fish.class);
		int specieBear = specieCount(Bear.class);
		int specieOtter = specieCount(Otter.class);
		for(int i = 0; i < population; i++){
			if(isFreeCell(i) == true){				
				outputRiver += "-";
			}
			else{								
				outputRiver += river[i].toString();
			}			
		}		
		outputRiver += "\n\n" + countAnimals + " Animal(s) : " + specieFish + " Fish(es), " + specieBear + " Bear(s), " + specieOtter + " Otter(s)" ;
		return outputRiver;			
	}
}