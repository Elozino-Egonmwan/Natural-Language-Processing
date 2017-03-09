public class LinearFnc{	
	
	public float[] applyTo(float[] domVec) {		
		float[] ranVec = new float[domVec.length];
		for (int i = 0; i < domVec.length; i++ ){			
			ranVec[i] = domVec[i] * 2;			
		}
		return ranVec;
	}
	 
}