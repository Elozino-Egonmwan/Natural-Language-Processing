import java.util.Arrays;

class Matrix{	
	private int rows;
	private int cols;
	private float [][] matrix;
	
	public Matrix(int m, int n){
		rows = m;
		cols = n;
		matrix = new float [rows][cols];		
	}
	
	public void initMatrix(LinearFnc lfc) {				
		for (int j = 0; j < cols; j++){
			float [] Mat = new float [cols];
			Mat [j] = 1;
			Mat = lfc.applyTo(Mat);
			for (int i = 0; i < rows; i++){
				matrix[i][j] = Mat[i];
			}				
		}	
	}
	
	public float [] applyTo(float[] domVec ) {
		float [] result = new float[rows];
		for (int i = 0; i < rows; i++){
			for (int j = 0; j < cols; j++){
				result[i] += matrix[i][j] * domVec[j];
			}
		}
		return result;		
	}
	
	public String toString(){
		System.out.println("\nFinal matrix " + rows + "X" + cols);
		System.out.println("obtained by multiplying each 'x' by 2 is :");
		for (int i = 0; i < rows; i ++){
			for (int j = 0; j < cols; j++){	
			    System.out.printf("%-6.1f", matrix[i][j]);				
			}
			System.out.println();
		}
		return "success";
	}
	
}