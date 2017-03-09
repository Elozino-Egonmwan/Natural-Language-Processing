
import java.util.Random;
import java.util.Arrays;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.lang.*;
//import Vertex;
public class AdjMapGraphTest{
	public static void main (String args[]){
		AdjacencyMapGraph graph = new AdjacencyMapGraph(false);
		AdjacencyMapGraph.Vertex vertexA,vertexB,vertexC,vertexD,vertexE;
		vertexA = graph.insertVertex('a');
		vertexB = graph.insertVertex('b');
		vertexC = graph.insertVertex('c');
		vertexD = graph.insertVertex('d');
		vertexE = graph.insertVertex('e');
		
		graph.insertEdge(vertexA,vertexB,'w');
		graph.insertEdge(vertexA,vertexC,'x');
		graph.insertEdge(vertexC,vertexD,'y');
		graph.insertEdge(vertexD,vertexE,'z');
	    graph.insertEdge(vertexE,vertexB,'v');
		
		System.out.println(graph.toString());
		System.out.println("Number of edges is: " + graph.numEdges() + " and number of vertices is: " +  graph.numVertices());
		System.out.println(graph.isBipartite());
	}		
}