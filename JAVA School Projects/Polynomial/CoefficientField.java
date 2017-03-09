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
package at.jku.teaching.swtech;

/**
 * Simple interface to describe a field.
 * 
 * @author Alexander Baumgartner
 */
public interface CoefficientField<T> {
	/**
	 * Adds the two given values
	 */
	T add(T val1, T val2);

	/**
	 * Multiplies the two given values
	 */
	T multiply(T val1, T val2);

	/**
	 * Multiplies the two given values
	 */
	T multiply(T val1, int n);

	/**
	 * Returns the multiplicative inverse of the given value
	 */
	T invert(T val);

	/**
	 * Returns the additive inverse of the given value
	 */
	T negate(T val);

	/**
	 * Returns the multiplicative unit element 1.
	 */
	T unitOne();

	/**
	 * Returns the additive unit element 0.
	 */
	T unitZero();
}
