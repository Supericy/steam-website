function SteamId(potentialId) {
	this.isCommunityId = function () {
		return this.potentialId.match(/^\d{17}$/);
	}

	this.isTextId = function () {
		return this.potentialId.match(/^(STEAM_)?[0-1]:[0-1]:\d{1,12}$/);
	}

	this.getCommunityID = function () {
		if (this.isCommunityId())
			return potentialId;

		var tokens = this.potentialId.split(":");

		var Y = parseInt(tokens[1]);
		var Z = parseInt(tokens[2]);

		console.log(Y);
		console.log(Z);

		// magic numbers derived from 0x0110000100000000, javascript only supports 2^53
		return "76561197" + ((Z * 2) + Y + 960265728);
	}

	this.potentialId = potentialId;

	if (!(this.isCommunityId() || this.isTextId()))
		throw new SteamException("Invalid SteamID Format");

	if (this.isTextId())
	{
		// strip off the 'STEAM_' part if it exists
		if ((pos = this.potentialId.indexOf('STEAM_')) > -1)
		{
			this.potentialId = this.potentialId.substr(6);
		}
	}
};



SteamId.prototype.isCommunityId = function () {
	return SteamId.isCommunityId(this.potentialId);
}

SteamId.prototype.isTextId = function () {
	return SteamId.isTextId(this.potentialId);
}



function SteamException(message) {
	this.message = message;
	this.name = "SteamException";
}