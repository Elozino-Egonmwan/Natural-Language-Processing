
/**
 * Maze 
 * @author Elozino Ofualagba
 */
import java.lang.*;
import java.io.*;
import java.util.*;
import java.util.Scanner;
public class Maze{
	private List<String> rawMaze = new ArrayList<String>();
	private int row, column;
	private char[][] maze;		
	private int startX;
	private int startY;
	private int endX;
	private int endY;
	
	public Maze(String mazeFile) throws IOException{		
		Scanner file = new Scanner(new File(mazeFile));
		while (file.hasNextLine()) {
		  String line = file.nextLine();
		  rawMaze.add(line);		  /**read file into a List of Strings */
		  row++;		  
		  column = line.length();		  
		}
		maze = new char[row][column];		/**store in a two dimensional array */
		storeMaze();
	}
	
	/** stores maze in a 2D array n sets start n end cordinates */
	private void storeMaze(){
		for(int i= 0; i < row; i++){
			for(int j = 0; j< column; j++){				
				maze[i][j] = rawMaze.get(i).charAt(j);	
				if(maze[i][j] == 'S'){
					startX = i;
					startY = j;
				}
				if(isExit(i,j)){
					endX = i;
					endY = j;
				}					
			}
		}
	}
	/** recursively finds solution to maze */
	public void solve(){
		boolean solved = false;
		solved= solveMaze(getStartX(),getStartY());
		if(solved)
			System.out.println("Maze solved");
		if(!solved)
			System.out.println("Solution not found");
	}
	
	private boolean solveMaze(int x, int y){
		boolean solved = false;	
		if(isValid(x,y) || (x== getStartX()&& y== getStartY())){			
			setVisited(x,y);
			if(x == getEndX() && y == getEndY())
				solved = true;
			else{
				solved = solveMaze(x+1,y); /**move North **/
				if(!solved)
					solved = solveMaze(x-1,y); /**move South **/
				if(!solved)
					solved = solveMaze(x,y+1); /**move East **/
				if(!solved)
					solved = solveMaze(x,y-1); /**move West **/
			}
			if(solved)
				maze[x][y] = '.';
		}
		return solved;
	}
	
	/** returns x cordinate of start position */
	public int getStartX(){
		return startX;
	}
	
	/** returns y cordinate of start position */
	public int getStartY(){
		return startY;
	}
	
	/** returns x cordinate of end position */
	public int getEndX(){
		return endX;
	}
	
	/** returns y cordinate of end position */
	public int getEndY(){
		return endY;
	}
	
	/** checks if a pair of cordinates leads to an exit of the maze */
	public boolean isExit(int x, int y){			
		return  (isFree(x,y) && ( x== 0 || x == row - 1  || y == 0  || y == column -1 )) ;			
	}
	
	/** checks if a cell is not a wall */
	public boolean isFree(int x, int y){		
		return maze[x][y] == ' ';
	}
	
	private void setVisited(int x, int y){
		maze[x][y] = ',';
	}
	
	private boolean isVisited(int x, int y){		
		return maze[x][y] == ',';
	}	
	
	private boolean isValid (int x, int y) {
      boolean result = false; 
      /** check if cell is in the bounds of the matrix **/
      if ( x >= 0 && x < row && y >= 0 && y < column)
         /** check if cell is not blocked and not previously visited.*/         
		if ( isFree(x,y) && !isVisited(x,y) )
            result = true;
      return result;
    }
	
	public String toString(){
		String s = "";
		for(int i = 0; i < row; i++){
			for(int j = 0; j < column; j++){
				if(maze[i][j] == ',')
					maze[i][j] = ' ';
				if(i==getStartX() && j == getStartY())
					maze[i][j] = 'S';
				s +=maze[i][j];
			}
			s+= "\n";
		}
		s+="Start cordinates: (" + getStartX() + "," + getStartY() + ").";
		s+="\nEnd cordinates: (" + getEndX() + "," + getEndY() + ").";
		return s;
	}
	
}
