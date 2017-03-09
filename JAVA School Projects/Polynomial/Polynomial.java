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
 *
 *
 */

/** NEWLY IMPLEMENTED METHODS
**  T add(T val1, T val2) and T multiply(T val1, T val2)
**/

import java.util.Comparator;
import java.util.Map.Entry;
import java.util.TreeMap;

/**
 * Simple polynomial with {@link Double} coefficients. For demonstration
 * purpose.
 * 
 * @author Alexander Baumgartner
 */
public class Polynomial {
	private int numVars;
	private TreeMap<int[], Double> monomials = new TreeMap<>(
			new Comparator<int[]>() {
				@Override
				public int compare(int[] v, int[] w) {
					for (int i = 0; i < v.length; i++) {
						int cmp = w[i] - v[i];
						if (cmp != 0)
							return cmp;
					}
					return 0;
				}
			});

	/**
	 * Create a polynomial with the specified number of indeterminates.
	 */
	public Polynomial(int numVars) {
		this.numVars = numVars;
	}

	/**
	 * Add a constant value
	 */
	public void addConstant(Double constant) {
		addIntern(constant, new int[numVars]);
	}
	
	/**
	 * Adds the two given values
	 */
	public <T extends Number> T add(T val1, T val2){
		Double total = (Double)val1.doubleValue() + (Double)val2.doubleValue();
		total =  (double) Math.round(total);
		Integer sum =  total.intValue();
		return (T)sum;
	}
	
	/**
	 * Multiplies the two given values
	 */
	public <T extends Number> T multiply(T val1, T val2){
		Double mult = (Double)val1.doubleValue() * (Double)val2.doubleValue();
		mult = (double)Math.round(mult);
		Integer mul = mult.intValue();
		return (T) mul;
	}

	/**
	 * Add a monomial and compute the total degree.
	 */
	public void add(Double coefficient, int... exponents) {
		if (exponents.length != numVars)
			throw new IllegalArgumentException("Wrong number of exponents");
		int[] gradedExp = new int[numVars + 1];
		int total = 0;
		for (int i = 0; i < numVars;) {
			int val = exponents[i];
			total += val;
			gradedExp[++i] = val;
		}
		gradedExp[0] = total;
		addIntern(coefficient, gradedExp);
	}

	private void addIntern(Double coeff, int... exponents) {
		Double oldCoeff = monomials.get(exponents);
		if (oldCoeff != null)
			coeff += oldCoeff;
		if (coeff != 0)
			monomials.put(exponents, coeff);
		else if (oldCoeff != null)
			monomials.remove(exponents);
	}

	/**
	 * Returns the total degree of the polynomial. The degree of the 0
	 * polynomial is defined as -1.
	 */
	public int degree() {
		return monomials.size() == 0 ? -1 : monomials.firstKey()[0];
	}

	/**
	 * Returns the leading coefficient of the polynomial.
	 */
	public Double leadingCoeff() {
		return monomials.size() == 0 ? 0.0 : monomials.firstEntry().getValue();
	}

	/**
	 * Add another polynomial
	 */
	public void add(Polynomial other) {
		if (other.numVars != numVars)
			throw new IllegalArgumentException("Wrong number of exponents");
		for (Entry<int[], Double> m : other.monomials.entrySet())
			addIntern(m.getValue(), m.getKey());
	}

	/**
	 * Subtract another polynomial
	 */
	public void subtract(Polynomial other) {
		if (other.numVars != numVars)
			throw new IllegalArgumentException("Wrong number of exponents");
		for (Entry<int[], Double> m : other.monomials.entrySet())
			addIntern(-m.getValue(), m.getKey());
	}

	@SuppressWarnings("unchecked")
	public Polynomial copy() {
		Polynomial cpy = new Polynomial(numVars);
		cpy.monomials = (TreeMap<int[], Double>) monomials.clone();
		return cpy;
	}

	/**
	 * Multiply this polynomial by a constant value.
	 */
	public void multiplyConstant(Double constant) {
		for (Entry<int[], Double> m : monomials.entrySet())
			m.setValue(m.getValue() * constant);
	}

	/**
	 * Multiply this polynomial by another polynomial and return the result.
	 */
	public Polynomial multiply(Polynomial p2) {
		if (p2.numVars != numVars)
			throw new IllegalArgumentException("Wrong number of exponents");
		int expLen = numVars + 1;
		Polynomial result = new Polynomial(numVars);
		for (Entry<int[], Double> m1 : monomials.entrySet()) {
			for (Entry<int[], Double> m2 : p2.monomials.entrySet()) {
				int[] expNew = new int[expLen];
				for (int i = 0; i < expLen; i++)
					expNew[i] = m1.getKey()[i] + m2.getKey()[i];
				result.addIntern(m1.getValue() * m2.getValue(), expNew);
			}
		}
		return result;
	}

	public Double eval(Double... point) {
		if (point.length != numVars)
			throw new IllegalArgumentException("Wrong dimension of point");
		Double ret = 0.0;
		for (Entry<int[], Double> m : monomials.entrySet()) {
			Double monomialEval = m.getValue();
			for (int i = 0; i < numVars;) {
				Double xi = point[i];
				for (int exp = m.getKey()[++i]; exp > 0; exp--)
					monomialEval *= xi; // Compute power
			}
			ret += monomialEval;
		}
		return ret;
	}

	/**
	 * Computes and returns the partial derivative w.r.t. the given variable
	 * index. The index <b>1 (ONE)</b> denotes the first variable x1! <b>Do not
	 * use 0 (ZERO)!</b>
	 */
	public Polynomial d(int i) {
		Polynomial result = new Polynomial(numVars);
		for (Entry<int[], Double> m : monomials.entrySet()) {
			int[] exps = m.getKey().clone();
			exps[0]--;
			exps[i]--;
			result.addIntern(m.getKey()[i] * m.getValue(), exps);
		}
		return result;
	}

	/**
	 * Computes the gradient of the polynomial
	 */
	public Polynomial[] gradient() {
		Polynomial[] grad = new Polynomial[numVars];
		for (int i = 0; i < numVars; grad[i] = d(++i))
			;
		return grad;
	}

	@Override
	public String toString() {
		StringBuilder sb = new StringBuilder();
		for (Entry<int[], Double> m : monomials.entrySet()) {
			if (sb.length() > 0)
				sb.append(' ').append('+').append(' ');
			sb.append(m.getValue());
			for (int i = 1; i <= numVars; i++) {
				int exp = m.getKey()[i];
				if (exp > 0)
					sb.append(' ').append('x').append(i);
				if (exp > 1)
					sb.append('^').append(exp);
			}
		}
		return sb.length() == 0 ? "0" : sb.toString();
	}
}
