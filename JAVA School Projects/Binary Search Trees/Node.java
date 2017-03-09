//package at.jku.teaching.swtech;

/**
 * Comparable node for the binary search tree. For demonstration purpose.
 * 
 * @author Alexander Baumgartner
 */
public class Node<E extends Comparable<E>> implements Comparable<Node<E>> {
	private E data;
	Node<E> leftChild;
	Node<E> rightChild;

	/**
	 * Construct a new node with the given data.
	 */
	public Node(E data) {
		this.data = data;
	}

	/**
	 * Returns the data inside the node.
	 */
	public E getData() {
		return data;
	}

	@Override
	public int compareTo(Node<E> other) {
		if (data == null)
			return other.data == null ? 0 : -1;
		return other.data == null ? 1 : data.compareTo(other.data);
	}
}