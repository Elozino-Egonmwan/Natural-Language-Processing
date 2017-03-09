import java.util.ArrayDeque;
//import Tree.*;

public class BST<E extends Comparable<E>> {
	private Node<E> root;

	/**
	 * Returns the node which corresponds to a given value, or null if its not
	 * present in the tree.
	 */
	public Node<E> find(E data) {
		Node<E> current = root;
		while (current != null && !data.equals(current.getData())) {
			if (current.getData().compareTo(data) > 0)
				current = current.leftChild;
			else
				current = current.rightChild;
		}
		return current;
	}

	/**
	 * Returns the node which corresponds to the minimum value w.r.t. compareTo,
	 * or null if the tree is empty.
	 */
	public Node<E> minimum() {
		Node<E> last = null;
		for (Node<E> n = root; n != null; n = n.leftChild)
			last = n;
		return last;
	}

	/**
	 * Create a node which contains the given data and insert it.
	 */
	public void insert(E data) {
		Node<E> newNode = new Node<>(data);
		if (root == null) {
			root = newNode;
			return;
		}
		for (Node<E> current = root; current != null;) {
			Node<E> parent = current;
			if (current.compareTo(newNode) > 0) {
				current = current.leftChild;
				if (current == null)
					parent.leftChild = newNode;
			} else {
				current = current.rightChild;
				if (current == null)
					parent.rightChild = newNode;
			}
		}
	}

	/**
	 * Inorder traversal of a binary tree visits all the nodes in the right
	 * order w.r.t. compareTo.
	 */
	public void inOrder(Visitor visitor) {
		inOrder(root, visitor);
	}

	private void inOrder(Node<E> current, Visitor visitor) {
		if (current == null)
			return;
		inOrder(current.leftChild, visitor);
		visitor.visit(current);
		inOrder(current.rightChild, visitor);
	}

	/**
	 * Levelorder traversal of a binary tree visits all the nodes in breadth
	 * manner.
	 */
	public void levelOrder(Visitor visitor) {
		java.util.Queue<Node<E>> queue = new ArrayDeque<>();
		queue.add(root);
		while (!queue.isEmpty()) {
			Node<E> current = queue.poll();
			visitor.visit(current);
			if (current.leftChild != null)
				queue.add(current.leftChild);
			if (current.rightChild != null)
				queue.add(current.rightChild);
		}
	}

	/**
	 * Abstract visitor class to perform operations on the visited nodes.
	 */
	public abstract class Visitor {
		public abstract void visit(Node<E> node);
	}

	@Override
	public String toString() {
		final StringBuilder sb = new StringBuilder();
		inOrder(new Visitor() {
			public void visit(Node<E> node) {
				sb.append(node.getData()).append(' ');
			}
		});
		return sb.toString();
	}

	private Node<E> getSuccessor(Node<E> delNode) {
		Node<E> successorParent = delNode;
		Node<E> successor = delNode;
		/**go to right child **/
		for (Node<E> n = delNode.rightChild; n != null; n = n.leftChild) {
			successorParent = successor;
			successor = n;
		}
		if (successor != delNode.rightChild) {
			successorParent.leftChild = successor.rightChild;
			successor.rightChild = delNode.rightChild;
		}
		return successor;
	}

	/**
	 * Returns true in case of success and false if the given node was not
	 * found.
	 */
	public boolean delete(E n) {
		/** finds node first **/
		Node<E> delNode = find(n);				
		if (delNode != null){			
			Node<E> parentNode = getParent(delNode);
			
			/** case 1: delNode is leaf **/
			if(isLeaf(delNode)){				
				if(parentNode.leftChild != null && parentNode.leftChild.compareTo(delNode) == 0)	
					parentNode.leftChild = null;
				else
					parentNode.rightChild = null;
				return true;
			}
			
			/** case 2: delNode has one child **/	
			if(!has2Children(delNode)){ 			
				if(parentNode.leftChild != null && parentNode.leftChild.compareTo(delNode) == 0)
					parentNode.leftChild = delNode.leftChild;
				else
					parentNode.rightChild = delNode.rightChild;
				return true;
			}
			
			/**case 3: delNode has 2 children **/
			if(has2Children(delNode)){
				Node<E> successor = getSuccessor(delNode);
				
				/**case 3a: delNode is root **/
				if(parentNode.compareTo(delNode)==0)
					root = successor;				
				
				/**case 3b: normal **/
				if(parentNode.compareTo(delNode) != 0){
					if(parentNode.leftChild != null && parentNode.leftChild.compareTo(delNode) == 0)
						parentNode.leftChild = successor;
					else
						parentNode.rightChild = successor;
				}
				
				/**refactor children **/
				if(successor.compareTo(delNode.leftChild) > 0)
					successor.leftChild = delNode.leftChild;
				else
					successor.rightChild = delNode.rightChild;
				return true;
			}
		}
		return false;
	}	
	
	
	/** returns parent node **/
	private Node<E> getParent(Node<E> node) {
		Node<E> current = root;		
		while (current != null && current.compareTo(node) != 0) {
			if(current.leftChild != null){				
				if(current.leftChild.compareTo(node) == 0)			
					return current;				
			}
			if(current.rightChild != null){				
				if(current.rightChild.compareTo(node) == 0)					
					return current;							
			}			
			if(current.compareTo(node) > 0)
				current = current.leftChild;
			else
				current = current.rightChild;			
		}
		return current;
	}	
	
	
	/** returns true if a node is leaf **/
	public boolean isLeaf(Node<E> node){
		return node.rightChild == null && node.leftChild== null;
	}
	
	/**returns true if node has 2 children **/
	public boolean has2Children(Node<E> node){
		return node.rightChild != null && node.leftChild != null;
	}
}
