import at.jku.student.softwareTech.*;

public interface EcoSystem  {
	Animal[] addAnimal (Animal specie, int number);		/** adds 'number' animals of type 'specie' to the ecosystem */
	Animal[] simulate(int rounds);						/**simulates the ecosystem */
	int livingEco(); 									/** counts number of living animals in ecosystem */
	int free();											/** Returns number of free cells **/
	int specieCount(Class specie); 						/** Counts the number of animals of a particular type **/
	int canAddSpecie(int existing); 					/**Returns how many more animals of a particular type can be added **/
	boolean isFreeCell(int cell);						/** checks if a cell is free **/
	String toString(); 									/** prints state information of each animal**/
	String toCompactString(); 							/**Prints compact state of EcoSystem **/
}
