import at.jku.student.softwareTech.*;

public interface EcoSystem  {
	Animal[] addAnimal (Animal specie, int number);	
	Animal[] simulate(int rounds);
	int Behavior(Animal attacker, Animal defender);	
	int livingEco();
	int free();	
	int specieCount(Class specie);
	int canAddSpecie(int existing);
	boolean isFreeCell(int cell);	
	Class getSpecieClass(Animal specie);
	String toString();
	String toCompactString();
}
