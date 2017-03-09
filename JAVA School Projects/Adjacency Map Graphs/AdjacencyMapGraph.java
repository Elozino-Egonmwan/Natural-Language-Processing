/*
 * Copyright 2015 Alexander Baumgartner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
//package at.jku.teaching.swtech;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.LinkedList;
import java.util.List;
import java.util.Map;
import java.util.Set;

/**
 * Graph implementation using an adjacency map. For demonstration purpose.
 * 
 * @author Alexander Baumgartner
 */
public class AdjacencyMapGraph<V, E extends Comparable<E>> {
	private boolean directed;
	private List<Vertex> vertices = new ArrayList<>();
	private List<Edge> edges = new ArrayList<>();
	private boolean isBipartite = true;
	

	/**
	 * Constructs an empty graph (either undirected or directed).
	 */
	public AdjacencyMapGraph(boolean directed) {
		this.directed = directed;
	}

	/**
	 * Returns the number of vertices of the graph
	 */
	public int numVertices() {
		return vertices.size();
	}

	/**
	 * Returns the vertices of the graph as an iterable collection
	 */
	public List<Vertex> vertices() {
		return vertices;
	}

	/**
	 * Returns the number of edges of the graph
	 */
	public int numEdges() {
		return edges.size();
	}

	/**
	 * Returns the edges of the graph as an iterable collection
	 */
	public List<Edge> edges() {
		return edges;
	}

	/**
	 * Returns the edge from u to v, or null if they are not adjacent.
	 */
	public Edge getEdge(Vertex u, Vertex v) {
		return u.getOutgoing().get(v);
	}

	/**
	 * Inserts and returns a new vertex with the given element.
	 */
	public Vertex insertVertex(V elem) {
		Vertex v = new Vertex(elem);
		vertices.add(v);
		return v;
	}

	/**
	 * Inserts and returns a new edge between u and v.
	 */
	public Edge insertEdge(Vertex u, Vertex v) {
		return insertEdge(u, v, null);
	}

	/**
	 * Inserts and returns a new edge between u and v, storing given element.
	 */
	public Edge insertEdge(Vertex u, Vertex v, E elem) {
		assert getEdge(u, v) == null;
		Edge e = new Edge(u, v, elem);
		edges.add(e);
		u.getOutgoing().put(v, e);
		v.getIncoming().put(u, e);
		return e;
	}

	@Override
	public String toString() {
		return "(" + vertices + ", " + edges + ")";
	}

	/**
	 * Depth first search starting at a given vertex v. The set known will be
	 * used to put all the reachable vertices and forest is the map of discovery
	 * edges.
	 */
	public void depthFirst(Vertex v, Set<Vertex> known, Map<Vertex, Edge> forest,List<Vertex> partitionX, List<Vertex> partitionY ) {
		known.add(v);			
		for (Edge e : v.getOutgoing().values()) {
			Vertex u = e.opposite(v);
			if(!e.isMarked()){
				Edge edge = getEdge(v,u); /** for every edge G, place one vertex in X and the other in Y **/
				partitionX.add(v);
				partitionY.add(u);			
				e.mark();
			}
			if (!known.contains(u)) {
				forest.put(u, e);
				depthFirst(u, known, forest, partitionY,partitionX);
			}				
		}
	}
	
	public boolean isBipartite(){
		List<Vertex> partitionX = new ArrayList<>(); /**new **/
	    List<Vertex> partitionY = new ArrayList<>(); /**new **/
		Map<Vertex,Edge> forst = depthFirstComplete(partitionX,partitionY);
		System.out.println("Partition X");
		for(int i = 0; i < partitionX.size(); i++){
			System.out.print(partitionX.get(i) + " ");
		}
		System.out.println();
		System.out.println("Partition Y");
		for(int i = 0; i < partitionY.size(); i++){
			System.out.print(partitionY.get(i) + " ");
		}
		System.out.println();
		List<Vertex> dup = new ArrayList<>(partitionX); /**if partition X contains any vertex that partition Y also contains, then G is not bipartite */ 
		dup.retainAll(partitionY);
		/*System.out.println("Duplicates");
		for(int i = 0; i < dup.size(); i++){			
			System.out.print(dup.get(i) + " ");			
		}*/
		if(dup.size() > 0)
			isBipartite = false;		
		return isBipartite;
	}
	

	/**
	 * Find a path from u to v.
	 */
	public List<Edge> constructPath(Vertex u, Vertex v, Map<Vertex, Edge> forest) {
		LinkedList<Edge> path = new LinkedList<>();
		if (forest.get(v) != null) {
			while (v != u) {
				Edge edge = forest.get(v);
				path.addFirst(edge);
				v = edge.opposite(v);
			}
		}
		return new ArrayList<>(path);
	}

	/**
	 * Returns the complete forest of connected components for an undirected
	 * graph using depth first search.
	 */
	public Map<Vertex, Edge> depthFirstComplete(List<Vertex> partitionX, List<Vertex> partitionY) {
		Set<Vertex> known = new HashSet<>();
		Map<Vertex, Edge> forest = new HashMap<>();
		for (Vertex u : vertices)
			if (!known.contains(u))
				depthFirst(u, known, forest, partitionX,partitionY);
		return forest;
	}

	/**
	 * Breath first search starting at a given vertex v. The set known will be
	 * used to put all the reachable vertices and forest is the map of discovery
	 * edges.
	 */
	public void breathFirst(Vertex v, Set<Vertex> known,
			Map<Vertex, Edge> forest) {
		java.util.Queue<Vertex> q = new LinkedList<>();
		known.add(v);
		q.add(v);
		while (!q.isEmpty()) {
			v = q.poll();
			for (Edge e : v.getOutgoing().values()) {
				Vertex u = e.opposite(v);
				if (!known.contains(u)) {
					forest.put(u, e);
					known.add(u);
					q.add(u);
				}
			}
		}
	}

	/**
	 * Returns the complete forest of connected components for an undirected
	 * graph using breath first search.
	 */
	public Map<Vertex, Edge> breathFirstComplete() {
		Set<Vertex> known = new HashSet<>();
		Map<Vertex, Edge> forest = new HashMap<>();
		for (Vertex u : vertices())
			if (!known.contains(u))
				breathFirst(u, known, forest);
		return forest;
	}

	/**
	 * A vertex of an adjacency map graph representation.
	 */
	public class Vertex {
		private V elem;
		private boolean marked = false;
		private Map<Vertex, Edge> outgoing, incoming;

		/**
		 * Constructs a new vertex storing the given element.
		 */
		public Vertex(V elem) {
			this.elem = elem;
			outgoing = new HashMap<>();
			if (directed)
				incoming = new HashMap<>();
			else
				incoming = outgoing;
		}

		/**
		 * Returns the element associated with the vertex.
		 */
		public V getElem() {
			return elem;
		}

		/**
		 * Returns the element associated with the vertex.
		 */
		public void setElem(V elem) {
			this.elem = elem;
		}

		/**
		 * Returns reference to the underlying map of outgoing edges.
		 */
		public Map<Vertex, Edge> getOutgoing() {
			return outgoing;
		}

		/**
		 * Returns reference to the underlying map of incoming edges.
		 */
		public Map<Vertex, Edge> getIncoming() {
			return incoming;
		}

		/**
		 * Returns the number of edges for which the vertex is the origin.
		 */
		public int outDegree() {
			return outgoing.size();
		}
		
		public void mark(){
			marked = true;
		}
		public boolean isMarked(){
		  return marked;
	    }

		/**
		 * Returns an iterable collection of edges for which the vertex is the
		 * origin.
		 */
		public Iterable<Edge> outgoingEdges() {
			return outgoing.values();
		}

		/**
		 * Returns the number of edges for which the vertex is the destination.
		 */
		public int inDegree() {
			return incoming.size();
		}

		/**
		 * Returns an iterable collection of edges for which the vertex is the
		 * destination.
		 */
		public Iterable<Edge> incomingEdges() {
			return incoming.values();
		}

		@Override
		public String toString() {
			return String.valueOf(elem);
		}
	}

	/**
	 * An edge between two vertices.
	 */
	public class Edge implements Comparable<Edge> {
		private E elem;
		private Vertex u, v;
		private boolean marked = false;

		/**
		 * Constructs an edge from u to v, storing the given element.
		 */
		public Edge(Vertex u, Vertex v, E elem) {
			this.elem = elem;
			this.u = u;
			this.v = v;
		}

		public Vertex opposite(Vertex w) {
			return v == w ? u : u == w ? v : null;
		}

		@Override
		public int compareTo(Edge o) {
			if (elem == null)
				return o.elem == null ? 0 : -1;
			return o.elem == null ? 1 : elem.compareTo(o.elem);
		}

		/**
		 * Returns the element associated with the edge.
		 */
		public E getElem() {
			return elem;
		}

		/**
		 * Returns the first end point.
		 */
		public Vertex getVertU() {
			return u;
		}

		/**
		 * Returns the second end point.
		 */
		public Vertex getVertV() {
			return v;
		}
		
		public void mark(){
			marked = true;
		}
		public boolean isMarked(){
		  return marked;
	    }

		@Override
		public String toString() {
			StringBuilder ret = new StringBuilder();
			if (directed)
				ret.append('(').append(u).append(',').append(v).append(')');
			else
				ret.append('{').append(u).append(',').append(v).append('}');
			if (elem != null)
				ret.append('-').append('>').append(elem);
			return ret.toString();
		}
	}
}
