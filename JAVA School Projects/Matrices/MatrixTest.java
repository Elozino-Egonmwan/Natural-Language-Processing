import java.util.Arrays;

public class MatrixTest{
	public static void main (String args[]){			
			Matrix Mat = new Matrix(4,4);
			LinearFnc  fnc = new LinearFnc();
			float [] test = {0.9f,1.87f,2.9f,3.5f};
			Mat.initMatrix(fnc);
			System.out.println (Arrays.toString(fnc.applyTo(test)));
			System.out.println (Arrays.toString(Mat.applyTo(test)));	
			String s = Mat.toString();	
	}
}