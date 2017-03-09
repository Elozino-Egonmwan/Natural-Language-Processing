
import java.io.*;
import java.util.*;
import java.lang.*;
public class MazeTest{
	public static void main (String args[]) throws IOException{
		Maze maze = new Maze ("maze1.txt");
		maze.solve();
		System.out.println(maze.toString());
	}		
}